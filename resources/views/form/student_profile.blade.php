<div class="row">
    <div class="form-group col-md-12 col-lg-6">
        <label for="student_lrn">Student LRN: <span style="color:red;">*</span></label>
        <input type="text" class="form-control" id="student_lrn" name="student_lrn" placeholder="Student LRN" required>
    </div>
    <div class="form-group col-md-12 col-lg-6">
        <label for="rfid_no">RFID No: <span style="color:red;">*</span></label>
        <input type="text" class="form-control" id="rfid_no" name="rfid_no" placeholder="Student RFID" required>
    </div>
    <div class="form-group col-md-12 col-lg-3">
        <label for="firstname">First Name: <span style="color:red;">*</span></label>
        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" required>
    </div>
    <div class="form-group col-md-12 col-lg-3">
        <label for="middle">Middle name: <span style="color:red;"></span></label>
        <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Middle Name">
    </div>
    <div class="form-group col-md-12 col-lg-3">
        <label for="lastname">Last Name: <span style="color:red;">*</span></label>
        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" required>
    </div>
    <div class="form-group col-md-12 col-lg-3">
        <label for="extension_name">Extension Name: <span style="color:red;"></span></label>
        <input type="text" class="form-control" id="extension_name" name="extension_name"
            placeholder="Extension Name">
    </div>
    <div class="col-lg-12">
        <p class="text-left text-danger"><strong>PERMANENT ADDRESS</strong></p>
    </div>
    <div class="form-group col-md-12 col-lg-3">
        <label for="province_code">Province: <span style="color:red;">*</span></label>
        <select class="form-control" id="province_code" name="province_code" required>
            <option selected="true" value="REQUIRED" disabled>-- Select Province --</option>
        </select>
    </div>
    <div class="form-group col-md-12 col-lg-3">
        <label for="municipality_code">Municipality: <span style="color:red;">*</span></label>
        <select class="form-control" id="municipality_code" name="municipality_code" required="true">
            <option selected="true" value="REQUIRED" disabled>-- Select Municipality --</option>
        </select>
    </div>
    <div class="form-group col-md-12 col-lg-3">
        <label for="brgy_code">Barangay: <span style="color:red;">*</span></label>
        <select class="form-control" id="brgy_code" name="brgy_code" required="true">
            <option selected="true" value="REQUIRED" disabled>-- Select Barangay --</option>
        </select>
    </div>
    <div class="form-group col-md-12 col-lg-3">
        <label for="zip_code">Zip Code: <span style="color:red;">*</span></label>
        <input type="text" class="form-control" id="zip_code" name="zip_code" placeholder="Zip Code" required
            readonly>
    </div>
    <div class="col-lg-12">
        <p class="text-left text-danger"><strong>STUDENT INFORMATION</strong></p>
    </div>
    <div class="form-group col-md-12 col-lg-3">
        <label for="religion">Religion: <span style="color:red;">*</span></label>
        <select id="religion" name="religion" class="form-control">
            <option selected="true" value="REQUIRED" disabled>-- Select Religion --</option>
            <option>Roman Catholic</option>
            <option>Seventh-Day Adventist</option>
            <option>Iglesia ni Cristo</option>
            <option>Jehovah Witnesses</option>
            <option>Pentecostal</option>
            <option>Church of Christ</option>
            <option>Christian</option>
            <option>Baptist</option>
            <option>God is Able</option>
            <option>UCCP</option>
            <option>Church of God</option>
            <option>Dating Daan</option>
            <option>Jesus is Miracle</option>
            <option>Rizal</option>
            <option>Robin</option>
            <option>JMCIM </option>
            <option>Mormons</option>
            <option>Magtotoo</option>
            <option>Protestant</option>
            <option>Born Again</option>
            <option>Assemblies of God</option>
            <option>Iglesia Filipina Independiente</option>
            <option>Muslim</option>
            <option>Iglesia Ni Cristo</option>
            <option>Jerusalem</option>
            <option>Foursquare</option>
            <option>United Church of God</option>
        </select>
    </div>
    <div class="form-group col-md-12 col-lg-3">
        <label for="birthday">Birthday: <span style="color:red;">*</span></label>
        <input type="date" class="form-control" id="birthday" name="birthday" required>
    </div>
    <div class="form-group col-md-12 col-lg-3">
        <label for="sex">Sex: <span style="color:red;">*</span></label>
        <select type="text" class="form-control" id="sex" name="sex">
            <option selected="true" value="REQUIRED" disabled>-- Select Sex --</option>
            <option>Male</option>
            <option>Female</option>
        </select>
    </div>
    <div class="form-group col-md-12 col-lg-3">
        <label for="disability">Disability: <span style="color:red;">*</span></label>
        <select id="disability" name="disability" class="form-control">
            <option selected="true" value="REQUIRED" disabled>-- Select Disability --</option>
            <option value="None">None</option>
            <option value="Communication Disability">Communication Disability</option>
            <option value="Disability due to Chronic Illness">Disability due to Chronic Illness</option>
            <option value="Learning Disability">Learning Disability</option>
            <option value="Intellectual Disability">Intellectual Disability</option>
            <option value="Orthopedic Disability">Orthopedic Disability</option>
            <option value="Mental/ Psychosocial Disability">Mental/Psychosocial Disability</option>
            <option value="Mental/ Psychosocial Disability">Mental/Psychosocial Disability</option>
        </select>
    </div>
    <div class="form-group col-md-12 col-lg-4">
        <label for="email">Email Address: <span style="color:red;">*</span></label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Email Address"
            required>
    </div>
    <div class="form-group col-md-12 col-lg-4">
        <label for="parent_contact">Parents Contact Number: <span style="color:red;">*</span></label>
        <input type="text" class="form-control" id="parent_contact" name="parent_contact"
            data-mask="(+63) 999-999-9999" placeholder="(+63)" required>
    </div>
    <div class="form-group col-md-12 col-lg-4">
        <label for="contact">Students Contact Number: <span style="color:red;">*</span></label>
        <input type="text" class="form-control" id="contact" name="contact" data-mask="(+63) 999-999-9999"
            placeholder="(+63)" required>
    </div>
    <div class="col-lg-12">
        <p class="text-left text-danger"><strong>PRESENT ADDRESS</strong></p>
    </div>
    <div class="form-group col-md-12 col-lg-3">
        <label for="present_province_code">Province: <span style="color:red;">*</span></label>
        <select class="form-control" id="present_province_code" name="present_province_code" required>
            <option selected="true" value="REQUIRED" disabled>-- Select Province --</option>
        </select>
    </div>
    <div class="form-group col-md-12 col-lg-3">
        <label for="present_municipality_code">Municipality: <span style="color:red;">*</span></label>
        <select class="form-control" id="present_municipality_code" name="present_municipality_code"
            required="true">
            <option selected="true" value="REQUIRED" disabled>-- Select Municipality --</option>
        </select>
    </div>
    <div class="form-group col-md-12 col-lg-3">
        <label for="present_brgy_code">Barangay: <span style="color:red;">*</span></label>
        <select class="form-control" id="present_brgy_code" name="present_brgy_code" required="true">
            <option selected="true" value="REQUIRED" disabled>-- Select Barangay --</option>
        </select>
    </div>
    <div class="form-group col-md-12 col-lg-3">
        <label for="present_zip_code">Zip Code: <span style="color:red;">*</span></label>
        <input type="text" class="form-control" id="present_zip_code" name="present_zip_code"
            placeholder="Zip Code" required readonly>
    </div>
    <div class="col-lg-12">
        <div class="form-group">
            <label>
                <input type="checkbox" value="" id="user_permanent_address"> <i></i> Use permanent address </label>
            <hr>
        </div>
    </div>
</div>
