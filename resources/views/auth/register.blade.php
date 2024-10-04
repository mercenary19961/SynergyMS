@extends('layouts.app')

@section('no-header') @endsection

@section('content')
<div class="flex flex-col md:flex-row justify-center items-start min-h-screen bg-gray-100 px-6 ">
    <!-- Left Column: Common User Details -->
    <div class="bg-white p-10 rounded-lg shadow-lg max-w-md w-full mr-10 mt-12">
        <h2 class="text-3xl pb-3 mb-2 font-bold text-center bg-gradient-to-r from-orange-500 to-pink-500 bg-clip-text text-transparent">Registration</h2>
        <p class="text-center text-gray-500 mb-6">Add a new user</p>

        @if (session('status'))
        <div class="mb-4 text-sm font-medium text-green-600">
            {{ session('status') }}
        </div>
        @endif

        <form id="registrationForm" method="POST" action="{{ route('register.user.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Common User Details -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input id="name" type="text" name="name" placeholder="Enter name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-red-500 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input id="email" type="email" name="email" placeholder="Enter email" value="{{ old('email') }}" required class="w-full px-4 py-2 border border-red-500 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" type="password" name="password" placeholder="Enter password" required class="w-full px-4 py-2 border border-red-500 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600">
            </div>

            <div class="mb-4">
                <label for="role_id" class="block text-sm font-medium text-gray-700">Role</label>
                <select id="role_id" name="role_id" class="w-full px-4 py-2 border border-red-500 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600" onchange="showRoleSpecificFields(this.value)">
                    <option value="2">Client</option>
                    <option value="3">Project Manager</option>
                    <option value="4">HR</option>
                    <option value="5">Employee</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Profile Image</label>
                <input id="image" type="file" name="image" class="w-full px-4 py-2 border border-red-500 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600">
            </div>

            <!-- Hidden Fields for Role-Specific input fields -->
            <div id="hidden_role_specific_fields"></div>

            <button type="submit" class="w-full py-2 rounded-lg text-white bg-gradient-to-r from-orange-500 to-pink-500 hover:from-orange-600 hover:to-pink-600 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:ring-offset-2">Register</button>
        </form>
    </div>

    <!-- Right Column: Role-Specific Fields -->
    <div id="role_specific_fields_box" class="bg-white p-10 rounded-lg shadow-lg max-w-md w-full hidden mt-12">
        <h2 class="text-3xl pb-3 mb-2 font-bold text-center bg-gradient-to-r from-pink-500 to-orange-500 bg-clip-text text-transparent">Role-Specific Details</h2>
        <p class="text-center text-gray-500 mb-6">Add new role details</p>
        <div id="role_specific_fields"></div>
    </div>
</div>

<script>
function showRoleSpecificFields(roleId) {
    let fields = '';
    let hiddenFields = '';
    document.getElementById('role_specific_fields_box').classList.remove('hidden');

    if (roleId == 3) { // Project Manager
        fields = `
        <div class="mb-4">
            <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
            <select id="department" name="department_display" class="w-full px-4 py-2 border border-red-500 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600" onchange="updateHiddenDepartmentField(this.value);">
                <option value="">Select Department</option>
                <option value="Software Development">Software Development</option>
                <option value="Network Engineering">Network Engineering</option>
                <option value="Data Analysis">Data Analysis</option>
                <option value="Technical Support">Technical Support</option>
                <option value="Quality Assurance">Quality Assurance</option>
                <option value="UX/UI">UX/UI</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="experience_years" class="block text-sm font-medium text-gray-700">Experience Years</label>
            <input id="experience_years" type="number" name="experience_years_display" placeholder="Enter years of experience" class="w-full px-4 py-2 border border-red-500 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600" oninput="updateHiddenField('experience_years_display', this.value);">
        </div>
        <div class="mb-4">
            <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number</label>
            <input id="contact_number" type="text" name="contact_number_display" placeholder="Enter contact number" class="w-full px-4 py-2 border border-red-500 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600" oninput="updateHiddenField('contact_number_display', this.value);">
        </div>`;
        hiddenFields = `
        <input type="hidden" name="department_id" id="hidden_department_id">
        <input type="hidden" name="experience_years_display" id="hidden_experience_years_display">
        <input type="hidden" name="contact_number_display" id="hidden_contact_number_display">
        `;
    } else if (roleId == 4) { // HR
        fields = `
        <div class="mb-4">
            <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
            <select id="department" name="department_display" class="w-full px-4 py-2 border border-red-500 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600" onchange="updateHiddenDepartmentField(this.value); updatePositionOptions(this.value);">
                <option value="">Select Department</option>
                <option value="Recruitment">Recruitment</option>
                <option value="Payroll">Payroll</option>
                <option value="Employee Relations">Employee Relations</option>
                <option value="Training & Development">Training & Development</option>
                <option value="Compliance">Compliance</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
            <select id="position" name="position_display" class="w-full px-4 py-2 border border-red-500 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600" onchange="updateHiddenField('position_display', this.value);">
                <option value="">Select Position</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number</label>
            <input id="contact_number" type="text" name="contact_number_display" placeholder="Enter contact number" class="w-full px-4 py-2 border border-red-500 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600" oninput="updateHiddenField('contact_number_display', this.value);">
        </div>
        <div class="mb-4">
            <label for="company_email" class="block text-sm font-medium text-gray-700">Company Email</label>
            <input id="company_email" type="email" name="company_email_display" placeholder="Enter company email" class="w-full px-4 py-2 border border-red-500 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600" oninput="updateHiddenField('company_email_display', this.value);">
        </div>`;
        hiddenFields = `
        <input type="hidden" name="department_id" id="hidden_department_id">
        <input type="hidden" name="position_display" id="hidden_position_display">
        <input type="hidden" name="contact_number_display" id="hidden_contact_number_display">
        <input type="hidden" name="company_email_display" id="hidden_company_email_display">
        `;
    } else if (roleId == 5) { // Employee
        fields = `
        <div class="mb-4">
            <label for="department" class="block text-sm font-medium text-gray-700">Department</label>
            <select id="department" name="department_display" class="w-full px-4 py-2 border border-red-500 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600" onchange="updateHiddenDepartmentField(this.value); updatePositionOptions(this.value);">
                <option value="">Select Department</option>
                <option value="Software Development">Software Development</option>
                <option value="Network Engineering">Network Engineering</option>
                <option value="Data Analysis">Data Analysis</option>
                <option value="Technical Support">Technical Support</option>
                <option value="Quality Assurance">Quality Assurance</option>
                <option value="UX/UI">UX/UI</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
            <select id="position" name="position_display" class="w-full px-4 py-2 border border-red-500 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600" onchange="updateHiddenField('position_display', this.value);">
                <option value="">Select Position</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="salary" class="block text-sm font-medium text-gray-700">Salary</label>
            <input id="salary" type="number" name="salary_display" step="50" placeholder="Enter salary" class="w-full px-4 py-2 border border-red-500 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600" oninput="updateHiddenField('salary_display', this.value);">
        </div>
        <div class="mb-4">
            <label for="date_of_joining" class="block text-sm font-medium text-gray-700">Date of Joining</label>
            <input id="date_of_joining" type="date" name="date_of_joining_display" placeholder="Enter date of joining" class="w-full px-4 py-2 border border-red-500 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600" oninput="updateHiddenField('date_of_joining_display', this.value);">
        </div>
        <div class="mb-4">
            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
            <input id="address" type="text" name="address_display" placeholder="Enter address" class="w-full px-4 py-2 border border-red-500 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600" oninput="updateHiddenField('address_display', this.value);">
        </div>
        <div class="mb-4">
            <label for="nationality" class="block text-sm font-medium text-gray-700">Nationality</label>
            <input id="nationality" type="text" name="nationality_display" placeholder="Enter nationality" class="w-full px-4 py-2 border border-red-500 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600" oninput="updateHiddenField('nationality_display', this.value);">
        </div>
        <div class="mb-4">
            <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
            <input id="age" type="number" name="age_display" placeholder="Enter age" class="w-full px-4 py-2 border border-red-500 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600" oninput="updateHiddenField('age_display', this.value);">
        </div>
        <div class="mb-4">
            <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
            <input id="date_of_birth" type="date" name="date_of_birth_display" placeholder="Enter date of birth" class="w-full px-4 py-2 border border-red-500 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600" oninput="updateHiddenField('date_of_birth_display', this.value);">
        </div>`;
        hiddenFields = `
        <input type="hidden" name="department_id" id="hidden_department_id">
        <input type="hidden" name="position_display" id="hidden_position_display">
        <input type="hidden" name="salary_display" id="hidden_salary_display">
        <input type="hidden" name="date_of_joining_display" id="hidden_date_of_joining_display">
        <input type="hidden" name="address_display" id="hidden_address_display">
        <input type="hidden" name="nationality_display" id="hidden_nationality_display">
        <input type="hidden" name="age_display" id="hidden_age_display">
        <input type="hidden" name="date_of_birth_display" id="hidden_date_of_birth_display">
        `;
    } else if (roleId == 2) { // Client
        fields = `
        <div class="mb-4">
            <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name</label>
            <input id="company_name" type="text" name="company_name_display" placeholder="Enter company name" class="w-full px-4 py-2 border border-red-500 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600" oninput="updateHiddenField('company_name_display', this.value);">
        </div>
        <div class="mb-4">
            <label for="industry" class="block text-sm font-medium text-gray-700">Industry</label>
            <input id="industry" type="text" name="industry_display" placeholder="Enter industry" class="w-full px-4 py-2 border border-red-500 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600" oninput="updateHiddenField('industry_display', this.value);">
        </div>
        <div class="mb-4">
            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
            <input id="address" type="text" name="address_display" placeholder="Enter address" class="w-full px-4 py-2 border border-red-500 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600" oninput="updateHiddenField('address_display', this.value);">
        </div>
        <div class="mb-4">
            <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
            <input id="website" type="text" name="website_display" placeholder="Enter website" class="w-full px-4 py-2 border border-red-500 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600" oninput="updateHiddenField('website_display', this.value);">
        </div>
        <div class="mb-4">
            <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number</label>
            <input id="contact_number" type="number" name="contact_number_display" placeholder="Enter contact number" class="w-full px-4 py-2 border border-red-500 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600" oninput="updateHiddenField('contact_number_display', this.value);">
        </div>`;
        hiddenFields = `
        <input type="hidden" name="company_name_display" id="hidden_company_name_display">
        <input type="hidden" name="industry_display" id="hidden_industry_display">
        <input type="hidden" name="address_display" id="hidden_address_display">
        <input type="hidden" name="website_display" id="hidden_website_display">
        <input type="hidden" name="contact_number_display" id="hidden_contact_number_display">
        `;
    }

    document.getElementById('role_specific_fields').innerHTML = fields;
    document.getElementById('hidden_role_specific_fields').innerHTML = hiddenFields;
}

// Update hidden field for department_id when a DEPARTMENT is selected
function updateHiddenDepartmentField(departmentName) {
    const departments = {
        "Software Development": 1,
        "Network Engineering": 2,
        "Data Analysis": 3,
        "Technical Support": 4,
        "Quality Assurance": 5,
        "UX/UI": 6,
        "Recruitment": 7,
        "Payroll": 8,
        "Employee Relations": 9,
        "Training & Development": 10,
        "Compliance": 11
    };

    const departmentId = departments[departmentName] || '';
    document.getElementById('hidden_department_id').value = departmentId;
    console.log('Department ID set to:', departmentId);  // Add this line for debugging
}

// Update POSITION options based on selected department
function updatePositionOptions(department) {
    const positionSelect = document.getElementById('position');
    positionSelect.innerHTML = ''; // clear existing options

    const positions = {
        "Recruitment": ["Recruitment Specialist", "Talent Acquisition Specialist", "HR Recruiter", "Senior Recruitment Consultant", "Recruitment Manager"],
        "Payroll": ["Payroll Coordinator", "Payroll Specialist", "Payroll Administrator", "Payroll Manager", "Compensation and Benefits Specialist"],
        "Employee Relations": ["Employee Relations Specialist", "Employee Relations Manager", "Labor Relations Specialist", "HR Generalist", "Conflict Resolution Specialist"],
        "Training & Development": ["Training Coordinator", "Learning and Development Specialist", "Training Manager", "Corporate Trainer", "Instructional Designer"],
        "Compliance": ["Compliance Officer", "HR Compliance Specialist", "Legal and Compliance Manager", "Risk and Compliance Analyst", "HR Auditor"],
        "Software Development": ["Software Developer", "Frontend Developer", "Backend Developer", "Full Stack Developer", "DevOps Engineer"],
        "Network Engineering": ["Network Engineer", "Network Administrator", "Network Architect", "Network Security Specialist", "Wireless Network Engineer"],
        "Data Analysis": ["Data Analyst", "Business Intelligence Analyst", "Data Scientist", "Data Engineer", "Data Visualization Specialist"],
        "Technical Support": ["Support Technician", "IT Support Specialist", "Help Desk Technician", "Technical Support Engineer", "Customer Support Specialist"],
        "Quality Assurance": ["QA Tester", "QA Engineer", "Quality Assurance Analyst", "Test Automation Engineer", "QA Manager"],
        "UX/UI": ["UX Designer", "UI Designer", "Product Designer", "UX Researcher", "Interaction Designer"]
    };

    // Add a default option
    let defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.text = 'Select Position';
    positionSelect.appendChild(defaultOption);

    // Add new options based on the selected department
    if (positions[department]) {
        positions[department].forEach(function(position) {
            let option = document.createElement('option');
            option.value = position;
            option.text = position;
            positionSelect.appendChild(option);
        });
    }
}

// Update hidden field based on input
function updateHiddenField(fieldId, value) {
    document.getElementById(`hidden_${fieldId}`).value = value;
}
</script>
@endsection
