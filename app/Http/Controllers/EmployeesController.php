<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Employee;
use App\Models\Education;
use App\Models\PastEmployment;
use App\Models\Bank;
use App\Models\Payroll;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class EmployeesController extends Controller
{


    public function index()
    {
        $employees = Employee::with(['user'])->get();

        // Total users
        $totalEmployees = User::count();

        // Count users grouped by role
        $usersByRole = User::select('role', DB::raw('count(*) as total'))
            ->groupBy('role')
            ->pluck('total', 'role'); // returns: ['admin' => 5, 'employee' => 10]

        return view('employees.index', compact('employees', 'totalEmployees', 'usersByRole'));
    }


    public function showAll(Request $request)
    {
        $dbColumns = (new Employee)->getFillable(); // Assuming fillable columns like 'user_id', 'joining_date', etc.
        $order = $request->post('order');
        $start = $request->post('start') ?? 0;
        $length = $request->post('length') ?? 10;
        $search = $request->post('search')['value'] ?? null;

        // Base query with relations (if needed)
        $query = Employee::with(['user:id,name,email,role']) // join related user
            ->select('employees.*'); // ensure employee fields are selected

        // Search
        if ($search) {
            $query->where(function ($q) use ($dbColumns, $search) {
                foreach ($dbColumns as $key => $column) {
                    if ($key === 0) {
                        $q->where($column, 'like', "%$search%");
                    } else {
                        $q->orWhere($column, 'like', "%$search%");
                    }
                }
            });
        }

        // Sorting
        if (isset($order[0]['dir'])) {
            $dir = $order[0]['dir'];
            $colIndex = $order[0]['column'] ?? false;
            $col = $dbColumns[$colIndex] ?? false;
            if ($col) {
                $query->orderBy($col, $dir);
            }
        } else {
            $query->orderBy('employees.id', 'desc');
        }

        // Count before limit for filtered
        $recordsFiltered = $query->count();

        // Pagination
        $data = $query->offset($start)->limit($length)->get()->toArray();

        // Add serial number
        foreach ($data as $index => &$item) {
            $item['s_no'] = $start + $index + 1;
        }

        // Total count
        $recordsTotal = Employee::count();

        // Prepare response
        $draw = $request->post('draw');

        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => intval($recordsTotal),
            'recordsFiltered' => intval($recordsFiltered),
            'data' => $data
        ]);
    }




    public function create()
    {
        $roles = Role::with('permissions')->get();
        $supervisors = Employee::with('user')->get()->pluck('user.name', 'id');
        return view('employees.create', compact('roles', 'supervisors'));
    }

    public function assignRole()
    {
        $employees = Employee::with('user')->get();
        $roles = Role::all();
        return view('employees.add', compact('employees', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:6',
            'role' => 'required|exists:roles,name',
            'dob' => 'nullable|date',
            'pan_number' => 'nullable|string|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
            'aadhar_number' => 'nullable|string|regex:/^[0-9]{12}$/',
            'country' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'address_line' => 'nullable|string',
            'pincode' => 'nullable|string|max:10',
            'highest_education' => 'nullable|string|max:100',
            'board' => 'nullable|string|max:100',
            'course' => 'nullable|string|max:100',
            'grade' => 'nullable|string|max:10',
            'edu_start_date' => 'nullable|date',
            'edu_end_date' => 'nullable|date',
            'organization_name' => 'nullable|string|max:255',
            'employment_functional_unit' => 'nullable|string|max:255',
            'employment_designation' => 'nullable|string|max:255',
            'joining_salary' => 'nullable|numeric',
            'last_salary' => 'nullable|numeric',
            'joining_date' => 'nullable|date',
            'relieving_date' => 'nullable|date',
            'bank_name' => 'nullable|string|max:100',
            'account_type' => 'nullable|string|in:savings,current',
            'account_name' => 'nullable|string|max:100',
            'account_number' => 'nullable|string|max:50|unique:banks,account_number',
            'ifsc' => 'nullable|string|regex:/^[A-Z]{4}0[A-Z0-9]{6}$/',
            'branch_name' => 'nullable|string|max:100',
            'bank_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'supervisor_id' => 'nullable|exists:employees,id',
            'payroll_designation' => 'nullable|string|max:255',
            'payroll_functional_unit' => 'nullable|string|max:255',
            'band' => 'nullable|string|max:20',
            'payroll_joining_date' => 'nullable|date',
            'offered_salary' => 'nullable|numeric',
            'last_salary_revision' => 'nullable|date',
            'latest_salary' => 'nullable|numeric',
            'salary_revision_count' => 'nullable|integer',
            'level_increase_count' => 'nullable|integer',
            'resign_date' => 'nullable|date',
            'last_working_date' => 'nullable|date',
            'payroll_relieving_date' => 'nullable|date',
        ]);

        DB::beginTransaction();

        try {
            // Create User
            $user = User::create([
                'name' => trim($request->first_name . ' ' . ($request->last_name ?? '')),
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);
            $user->assignRole($request->role);

            // Create Employee
            $employeeData = array_filter([
                'user_id' => $user->id,
                'dob' => $request->dob,
                'pan_number' => $request->pan_number,
                'aadhar_number' => $request->aadhar_number,
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'address_line' => $request->address_line,
                'pincode' => $request->pincode,
            ]);
            $employee = Employee::create($employeeData);

            // Create Education if any field is provided
            $educationData = array_filter([
                'user_id' => $employee->id,
                'highest_education' => $request->highest_education,
                'board' => $request->board,
                'course' => $request->course,
                'grade' => $request->grade,
                'edu_start_date' => $request->edu_start_date,
                'edu_end_date' => $request->edu_end_date,
            ]);
            if (count($educationData) > 1) { // Exclude user_id
                Education::create($educationData);
            }

            // Create Past Employment if any field is provided
            $pastEmploymentData = array_filter([
                'user_id' => $employee->id,
                'organization_name' => $request->organization_name,
                'functional_unit' => $request->employment_functional_unit,
                'designation' => $request->employment_designation,
                'joining_salary' => $request->joining_salary,
                'last_salary' => $request->last_salary,
                'joining_date' => $request->joining_date,
                'relieving_date' => $request->relieving_date,
            ]);
            if (count($pastEmploymentData) > 1) { // Exclude user_id
                PastEmployment::create($pastEmploymentData);
            }

            // Create Bank if any field is provided and no existing record
            $bankData = array_filter([
                'user_id' => $employee->id,
                'bank_name' => $request->bank_name,
                'account_type' => $request->account_type,
                'account_name' => $request->account_name,
                'account_number' => $request->account_number,
                'ifsc' => $request->ifsc,
                'branch_name' => $request->branch_name,
            ]);
            if (count($bankData) > 1) { // Exclude user_id
                if (Bank::where('user_id', $employee->id)->exists()) {
                    DB::rollBack();
                    return back()->withErrors(['error' => 'Bank data already exists for this employee.']);
                }
                $bank = new Bank($bankData);
                if ($request->hasFile('bank_file')) {
                    $bank->bank_file = $request->file('bank_file')->store('bank_docs');
                }
                $bank->save();
            }

            // Create Payroll if any field is provided
            $payrollData = array_filter([
                'user_id' => $employee->id,
                'supervisor_id' => $request->supervisor_id,
                'designation' => $request->payroll_designation,
                'functional_unit' => $request->payroll_functional_unit,
                'band' => $request->band,
                'joining_date' => $request->payroll_joining_date,
                'offered_salary' => $request->offered_salary,
                'last_salary_revision' => $request->last_salary_revision,
                'latest_salary' => $request->latest_salary,
                'salary_revision_count' => $request->salary_revision_count,
                'level_increase_count' => $request->level_increase_count,
                'resign_date' => $request->resign_date,
                'last_working_date' => $request->last_working_date,
                'relieving_date' => $request->payroll_relieving_date,
            ]);
            if (count($payrollData) > 1) { // Exclude user_id
                Payroll::create($payrollData);
            }

            DB::commit();
            return redirect()->route('admin.employees.index')->with('success', 'Employee created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show(Employee $employee)
    {
        $employee->load(['user', 'education', 'pastEmployment', 'bank', 'payroll']);
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $employee->load(['user', 'education', 'pastEmployment', 'bank', 'payroll']);
        $roles = Role::all();
        $supervisors = Employee::with('user')->where('id', '!=', $employee->id)->get()->pluck('user.name', 'id');
        return view('employees.edit', compact('employee', 'roles', 'supervisors'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $employee->user->id,
            'password' => 'nullable|string|confirmed|min:6',
            'role' => 'required|exists:roles,name',
            'dob' => 'nullable|date',
            'pan_number' => 'nullable|string|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
            'aadhar_number' => 'nullable|string|regex:/^[0-9]{12}$/',
            'country' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'address_line' => 'nullable|string',
            'pincode' => 'nullable|string|max:10',
            'highest_education' => 'nullable|string|max:100',
            'board' => 'nullable|string|max:100',
            'course' => 'nullable|string|max:100',
            'grade' => 'nullable|string|max:10',
            'edu_start_date' => 'nullable|date',
            'edu_end_date' => 'nullable|date',
            'organization_name' => 'nullable|string|max:255',
            'employment_functional_unit' => 'nullable|string|max:255',
            'employment_designation' => 'nullable|string|max:255',
            'joining_salary' => 'nullable|numeric',
            'last_salary' => 'nullable|numeric',
            'joining_date' => 'nullable|date',
            'relieving_date' => 'nullable|date',
            'bank_name' => 'nullable|string|max:100',
            'account_type' => 'nullable|string|in:savings,current',
            'account_name' => 'nullable|string|max:100',
            'account_number' => 'nullable|string|max:50|unique:banks,account_number,' . ($employee->bank ? $employee->bank->id : null),
            'ifsc' => 'nullable|string|regex:/^[A-Z]{4}0[A-Z0-9]{6}$/',
            'branch_name' => 'nullable|string|max:100',
            'bank_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'supervisor_id' => 'nullable|exists:employees,id',
            'payroll_designation' => 'nullable|string|max:255',
            'payroll_functional_unit' => 'nullable|string|max:255',
            'band' => 'nullable|string|max:20',
            'payroll_joining_date' => 'nullable|date',
            'offered_salary' => 'nullable|numeric',
            'last_salary_revision' => 'nullable|date',
            'latest_salary' => 'nullable|numeric',
            'salary_revision_count' => 'nullable|integer',
            'level_increase_count' => 'nullable|integer',
            'resign_date' => 'nullable|date',
            'last_working_date' => 'nullable|date',
            'payroll_relieving_date' => 'nullable|date',
        ]);

        DB::beginTransaction();

        try {
            // Update User
            $userData = array_filter([
                'name' => trim($request->first_name . ' ' . ($request->last_name ?? '')),
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request->password) : $employee->user->password,
                'role' => $request->role,
            ]);
            $employee->user->update($userData);
            $employee->user->syncRoles($request->role);

            // Update Employee
            $employeeData = array_filter([
                'dob' => $request->dob,
                'pan_number' => $request->pan_number,
                'aadhar_number' => $request->aadhar_number,
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'address_line' => $request->address_line,
                'pincode' => $request->pincode,
            ]);
            $employee->update($employeeData);

            // Update or Create Education
            $educationData = array_filter([
                'highest_education' => $request->highest_education,
                'board' => $request->board,
                'course' => $request->course,
                'grade' => $request->grade,
                'edu_start_date' => $request->edu_start_date,
                'edu_end_date' => $request->edu_end_date,
            ]);
            if (count($educationData) > 0) {
                if ($employee->education) {
                    $employee->education->update($educationData);
                } else {
                    Education::create(array_merge(['user_id' => $employee->id], $educationData));
                }
            } elseif ($employee->education) {
                $employee->education->delete();
            }

            // Update or Create Past Employment
            $pastEmploymentData = array_filter([
                'organization_name' => $request->organization_name,
                'functional_unit' => $request->employment_functional_unit,
                'designation' => $request->employment_designation,
                'joining_salary' => $request->joining_salary,
                'last_salary' => $request->last_salary,
                'joining_date' => $request->joining_date,
                'relieving_date' => $request->relieving_date,
            ]);
            if (count($pastEmploymentData) > 0) {
                if ($employee->pastEmployment) {
                    $employee->pastEmployment->update($pastEmploymentData);
                } else {
                    PastEmployment::create(array_merge(['user_id' => $employee->id], $pastEmploymentData));
                }
            } elseif ($employee->pastEmployment) {
                $employee->pastEmployment->delete();
            }

            // Update or Create Bank
            $bankData = array_filter([
                'bank_name' => $request->bank_name,
                'account_type' => $request->account_type,
                'account_name' => $request->account_name,
                'account_number' => $request->account_number,
                'ifsc' => $request->ifsc,
                'branch_name' => $request->branch_name,
            ]);
            if (count($bankData) > 0) {
                if ($employee->bank) {
                    $employee->bank->update($bankData);
                } else {
                    $bank = new Bank(array_merge(['user_id' => $employee->id], $bankData));
                    if ($request->hasFile('bank_file')) {
                        $bank->bank_file = $request->file('bank_file')->store('bank_docs');
                    }
                    $bank->save();
                }
            } elseif ($employee->bank) {
                $employee->bank->delete();
            }

            // Update or Create Payroll
            $payrollData = array_filter([
                'supervisor_id' => $request->supervisor_id,
                'designation' => $request->payroll_designation,
                'functional_unit' => $request->payroll_functional_unit,
                'band' => $request->band,
                'joining_date' => $request->payroll_joining_date,
                'offered_salary' => $request->offered_salary,
                'last_salary_revision' => $request->last_salary_revision,
                'latest_salary' => $request->latest_salary,
                'salary_revision_count' => $request->salary_revision_count,
                'level_increase_count' => $request->level_increase_count,
                'resign_date' => $request->resign_date,
                'last_working_date' => $request->last_working_date,
                'relieving_date' => $request->payroll_relieving_date,
            ]);
            if (count($payrollData) > 0) {
                if ($employee->payroll) {
                    $employee->payroll->update($payrollData);
                } else {
                    Payroll::create(array_merge(['user_id' => $employee->id], $payrollData));
                }
            } elseif ($employee->payroll) {
                $employee->payroll->delete();
            }

            DB::commit();
            return redirect()->route('admin.employees.index')->with('success', 'Employee updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Employee $employee)
    {
        DB::beginTransaction();
        try {
            if ($employee->education) {
                $employee->education->delete();
            }
            if ($employee->pastEmployment) {
                $employee->pastEmployment->delete();
            }
            if ($employee->bank) {
                $employee->bank->delete();
            }
            if ($employee->payroll) {
                $employee->payroll->delete();
            }

            if ($employee->user) {
                $employee->user->delete();
            }

            $employee->delete();

            DB::commit();
            return response()->json([
                'success' => 'Employee deleted successfully.',
                'tableReqload' => true
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Deletion failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
