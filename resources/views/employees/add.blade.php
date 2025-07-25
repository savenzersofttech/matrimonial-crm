@extends('layouts.main')

@section('title', 'Assign Leads')
@section('meta_description', 'Assign leads to employees easily.')

@section('content')
<div class="section-start">
  <div class="row">
    <div class="col-12">
      <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
          <h4 class="mb-0">Assign Leads</h4>
          <div class="d-flex align-items-center gap-2 flex-wrap">
            <a class="btn btn-primary" href="#">
              <i class="fas fa-arrow-left"></i> Back to Leads
            </a>
          </div>
        </div>

        <div class="card-body">
          
            @csrf
            <div class="mb-3">
              <label for="lead" class="form-label">Select Lead</label>
              <select class="form-select" id="lead" name="lead_id">
                <option value="">-- Select Lead --</option>
                <option value="1">Lead #1 - John Doe</option>
                <option value="2">Lead #2 - Jane Smith</option>
                <option value="3">Lead #3 - Bob Johnson</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="employee" class="form-label">Assign To Employee</label>
              <select class="form-select" id="employee" name="employee_id">
                <option value="">-- Select Employee --</option>
                <option value="1">Abhi Kumar</option>
                <option value="2">Nisha Kumari</option>
                <option value="3">Pramod Rana</option>
              </select>
            </div>

            <button type="submit" class="btn btn-success">
              <i class="fas fa-paper-plane"></i> Assign Lead
            </button>
          </form>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
