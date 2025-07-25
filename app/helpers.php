<?php

if (!function_exists('getDietOptions')) {
    function getDietOptions()
    {
        return [
            'Vegetarian',
            'Non-Vegetarian',
            'Vegan',
            'Eggetarian',
            'Jain Vegetarian', 
        'Other'       ];
    }
}

if (!function_exists('getDrinkingOptions')) {
    function getDrinkingOptions()
    {
        return [
            'Never',
            'Regularly',
            'Socially',
        ];
    }
}

if (!function_exists('getSmokingOptions')) {
    function getSmokingOptions()
    {   
        return [
            'Never',
            'Regularly',
            'Socially',
        ];
    }
}

if (!function_exists('getHealthStatusOptions')) {
    function getHealthStatusOptions()
    {   
        return [
            'No Health Problems',
            'HIV Positive',
            'Diabetes',
            'Low BP',
            'High BP',
            'Heart Ailments',
            'Other'
            
        ];
    }
}

if (!function_exists('getFamilyAffluenceOptions')) {
    function getFamilyAffluenceOptions()
    {
        return [
             'Ultra Rich / Elite',
             'Wealthy / Business Class',
             'Affluent',
             'Upper Middle Class',
             'Middle Class',
             'Lower Middle Class',
             'Working Class',
             'Lower Class',
             'Below Poverty Line',
        ];
    }
}

if (!function_exists('getFamilyValuesOptions')) {
    function getFamilyValuesOptions()
    {
        return [
             'Orthodox',
             'Traditional',
             'Conservative',
             'Moderate',
             'Liberal',
             'Progressive',
             'Spiritual',
        ];
    }
}

if (!function_exists('getEducationFieldOptions')) {
    function getEducationFieldOptions()
    {
        return [
            
            'Arts & Humanities', 'Commerce', 'Science', 'Engineering', 'Medical',
            'Law', 'Management', 'Computers / IT', 'Education / Teaching', 'Architecture',
            'Design / Fashion', 'Social Sciences', 'Journalism / Media', 'Finance / Accounting', 'Pharmacy',
            'Nursing', 'Agriculture', 'Hospitality / Tourism', 'Aviation', 'Animation / Multimedia',
            'Fine Arts', 'Performing Arts', 'Event Management', 'Interior Design', 'Data Science',
            'Artificial Intelligence', 'Cyber Security', 'Blockchain', 'Game Development', 'Machine Learning',
            'Physics', 'Chemistry', 'Mathematics', 'Biology', 'Zoology',
            'Botany', 'Biotechnology', 'Microbiology', 'Environmental Science', 'Forensic Science',
            'Statistics', 'Ayurveda', 'Homeopathy', 'Unani', 'Physiotherapy',
            'Occupational Therapy', 'Public Health', 'Dietetics & Nutrition', 'Social Work', 'Psychology',
            'Political Science', 'Public Administration', 'Sociology', 'Economics', 'History',
            'Geography', 'Philosophy', 'Library Science', 'Defense / Military Studies', 'Foreign Languages',
            'Other'
           
        ];
    }
}



if (!function_exists('getEducationLevels')) {
    function getEducationLevels()
    {
        return [
            'No Formal Education',
            'Primary School',
            'High School (10th)',
            'Higher Secondary (12th)',
            'Diploma / ITI',
            'Bachelor Degree',
            'Master Degree',
            'Doctorate / PhD',
            'Professional Course (CA / CS / etc.)',
            'Other',
        ];
    }
}




if (!function_exists('getMaritalStatusOptions')) {
    function getMaritalStatusOptions()
    {
        return [
            'Never Married',
            'Divorced',
            'Widowed',
            'Separated',
            'Awaiting Divorce',
            'Annulled'
        ];
    }
}

if (!function_exists('complexionOptions')) {
    function complexionOptions()
    {
        return [
            'Fair',
            'Wheatish',
            'Wheatish Brown',
            'Brown',
            'Dark',
            'Other'
        ];
    }
}


if (!function_exists('bodyTypeOptions')) {
    function bodyTypeOptions()
    {
        return [
            'Slim',
            'Average',
            'Athletic',
            'Heavy',
            'Other',
        ];
    }
}


if (!function_exists('bloodGroupOptions')) {
    function bloodGroupOptions()
    {
        return [
            'A+',
            'A-',
            'B+',
            'B-',
            'AB+',
            'AB-',
            'O+',
            'O-',
            'Don\'t Know',
        ];
    }
}



  



if (!function_exists('getOccupationOptions')) {
    function getOccupationOptions()
    {
        return [
         
            'Not Working',  'Government Employee', 'Private Job', 'Business',
            'Self Employed', 'Entrepreneur', 'Doctor', 'Engineer', 'Teacher',
            'Professor', 'Lawyer', 'Scientist', 'Architect', 'Artist',
            'Actor', 'Model', 'Journalist', 'Banker', 'Accountant',
            'Civil Services (IAS/IPS/IRS)', 'Defense Personnel', 'Pilot', 'Chef', 'Designer',
            'Sports Person', 'Social Worker', 'Clergy / Religious Work', 'Politician', 'Freelancer',
            'Retired',  'Housewife', 'Researcher', 'Consultant', 'IT Professional',
            'Pharmacist', 'Nurse', 'Healthcare Professional', 'Sales & Marketing', 'Customer Service',
            'Logistics & Supply Chain', 'Real Estate', 'Construction', 'Manufacturing', 'Agriculture',
            'Hospitality', 'Tourism', 'Aviation', 'Telecommunications', 'Media & Entertainment',
            'Information Technology', 'Finance & Banking', 'Insurance', 'Legal Services', 'Public Sector',
            'Non-Profit / NGO', 'Government Contractor', 'Freelance Writer', 'Content Creator', 'Digital Marketing',
            'Data Analyst', 'Cybersecurity', 'Blockchain Developer', 'Artificial Intelligence', 'Machine Learning',
            'Game Developer', 'Web Developer', 'Mobile App Developer', 'Cloud Computing', 'DevOps Engineer',
            'Other',
        ];
    }
}

if (!function_exists('manglikOptions')) {
    function manglikOptions()
    {
        return [
            'Yes',
            'No',
            'Partial',
            "Don't Know",
        ];
    }
}

if (!function_exists('contactPersonOptions')) {
    function contactPersonOptions()
    {
        return [
            'Self',
            'Family',
            'Friend',
            'Other',
        ];
    }
}

if (!function_exists('profileCreateOptions')) {
    function profileCreateOptions()
    {
        return [
            'Self',
            'Son',
            'Daughter',
            'Brother',
            'Sister',
            'Relative',
            'Friend',
            'Other'
        ];
    }
}

function getIncomeRanges(): array
{
    return [
        'Below ₹2 Lakh',
        '₹2 – 3 Lakh',
        '₹3–4 Lakh',
        '₹4–5 Lakh',
        '₹5–6 Lakh',
        '₹6–7 Lakh',
        '₹7–10 Lakh',
        '₹10–15 Lakh',
        '₹15–20 Lakh',
        '₹20–25 Lakh',
        '₹25–30 Lakh',
        '₹30–50 Lakh',
        '₹50 Lakh  1 Crore',
        '₹1–1.5 Crore',
        '₹1.5–2 Crore',
        '₹2–2.5 Crore',
        '₹2.5–3 Crore',
        'Above ₹3 Crore',
    ];
}



if (!function_exists('getDiscountOptions')) {
    function getDiscountOptions()
    {
        return [
            0 => 'No Discount',
            1 => '5%',
            2 => '10%',
            3 => '20%',
            4 => '30%',
        ];
    }
}

if (!function_exists('getFamilyTypeOptions')) {
    function getFamilyTypeOptions()
    {

        return [
            'Joint',
            'Nuclear',
            'Extended',
            'Single Parent',
        ];
    }
}

if (!function_exists('getFamilyAffluenceOptions')) {
    function getFamilyAffluenceOptions()
    {
        return [
            'Ultra Rich / Elite',
            'Wealthy / Business Class',
            'Affluent',
            'Upper Middle Class',

            'Middle Class',
            'Lower Middle Class',
            'Working Class',
            'Lower Class',
            'Below Poverty Line',
        ];
    }
} 

if (!function_exists('getFamilyValuesOptions')) {
    function getFamilyValuesOptions()
    {
        return [
            'Orthodox',
            'Traditional',
            'Conservative',
            'Moderate',
        ];
    }
}

        
if (!function_exists('fatherOptions')) {
    function fatherOptions()
    {
        return [
            'Employed',
            'Businessman',
            'Retired',
            'Homemaker',
            'Passed Away',
            'Other',
        ];
    }
}

if (!function_exists('motherOptions')) {
    function motherOptions()
    {
        return [
            'Employed',
            'BusinessWoman',
            'Retired',
            'Homemaker',
            'Passed Away',
            'Other',
        ];
    }
}

if (!function_exists('religionOption')) {
    function religionOption()
    {
        return [
            'Hindu',
            'Muslim',
            'Christian',
            'Sikh',
            'Jain',
            'Parsi',
            'Buddhist',
            'Jewish',
            'Other',
        ];
    }
}

if (!function_exists('casteOption')) {
    function casteOption()
    {
        return [
            'Agarwal',
            'Brahmin',
            'Kayastha',
            'Shia',
            'Sunni',
            'Dawoodi Bohra',
            'Roman Catholic',
            'Protestant',
            'Gursikh',
            'Labana',
            'No Religion',
        ];
    }
}