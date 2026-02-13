<!DOCTYPE html>
<html lang="">
<?php session_start(); ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration | LHS Clinic</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="..\js\bootstrap.bundle.min.js" />
    <link rel="icon" type="image/x-icon" href="../Pics/Logos/Lagro_High_School_logo.png">
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: green;
            --secondary-color: blue;
            --font-color: white;
            --gradient-color: linear-gradient(90deg, rgb(10, 89, 52) 50%, rgb(55, 123, 77) 100%);
            --input-color: #f1f1f1;
            --shadow: 0 2px 5px rgba(0, 0, 0, 0.4)
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .flex-container {
            display: flex;
            justify-content: space-between;
        }

        .sidebar-container {
            margin-bottom: -10px;
        }

        main {
            display: grid;
            grid-template-columns: minmax(250px, 2fr);
            gap: 50px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.7);
            border-radius: 16px;
            width: 70%;
            margin: auto;
            padding: 10px;
            background-color: white;
            margin-top: 20px;

        }

        .container {
            margin: auto;
            padding: 10px;
            width: 100%;
            margin-bottom: 18px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            padding: 7px 10px 7px 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="email"],
        input[type="file"],
        input[type="date"],
        select {
            width: 100%;
            height: 35px;
            padding: 3px;
            box-sizing: border-box;
            border-radius: 8px;
            border: none;
            background-color: var(--input-color);
            box-shadow: var(--shadow);
        }

        input[type="file"] {
            border-bottom: 1px solid black;
            width: 100%;
            box-sizing: border-box;
            background-color: var(--input-color);
            box-shadow: var(--shadow);
        }

        textarea {
            width: 100%;
            height: 80px;
            padding: 3px;
            box-sizing: border-box;
            border-radius: 8px;
            border: none;
            resize: vertical;
            background-color: var(--input-color);
            box-shadow: var(--shadow);
        }

        .register-label {
            text-align: center;
            position: relative;
            background: var(--gradient-color);
            color: var(--font-color);
            font-weight: bold;
            padding: 10px;
            height: 60px;
            line-height: 40px;
            margin: -30px;
            margin-bottom: 30px;
            box-shadow: 0px 5px 3px 0px rgba(0, 0, 0, 0.2);
        }

        /* LRN Search Styles */
        .lrn-search-wrapper {
            position: relative;
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .lrn-search-wrapper input[type="text"] {
            flex: 1;
        }

        .lrn-search-wrapper button {
            white-space: nowrap;
        }

        .lrn-search-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background-color: white;
            border: 1px solid #999;
            border-top: none;
            border-radius: 0 0 8px 8px;
            max-height: 200px;
            overflow-y: auto;
            display: none;
            z-index: 100;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .lrn-search-dropdown .lrn-result-item {
            padding: 10px 12px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        .lrn-search-dropdown .lrn-result-item:hover {
            background-color: #e8f5e9;
        }

        .lrn-search-dropdown .lrn-result-item:last-child {
            border-bottom: none;
        }

        .lrn-result-item .lrn-number {
            font-weight: bold;
            color: rgb(10, 89, 52);
        }

        .lrn-result-item .lrn-name {
            color: #555;
            font-size: 13px;
        }

        .lrn-no-result {
            padding: 10px 12px;
            color: #999;
            font-style: italic;
            font-size: 14px;
        }

        #home::after {
            width: 100%;
        }

        #clearBtn {
            background-color: rgb(161, 59, 60);
            border-color: rgb(161, 59, 60);
        }

        #clearBtn:hover {
            background-color: rgb(126, 43, 45);
            border-color: rgb(126, 43, 45);
        }
    </style>
</head>

<body>

    <div class="flex-container">

        <div class="sidebar-container">
            <?php include '../include/sidebar.php'; ?>
        </div>

        <main class="mb-5">
            <form action="../process/insert.php" method="post" enctype="multipart/form-data">

                <div class="container">
                    <table border="0" style="table-layout: fixed;">
                        <tr>
                            <th colspan="2" style="text-align: center;">
                                <h4 class="register-label">STUDENT INFORMATION</h4>
                            </th>
                        </tr>
                        <tr>
                            <td>LRN: </td>
                            <td>GRADE & SECTION: </td>
                        </tr>
                        <tr>
                            <!-- <td><input type="number" name="lrn" id="lrn-field" oninput="if(this.value.length > 12) this.value = this.value.slice(0, 12);" required autocomplete="off"> </td> -->
                            <td>
                                <div class="lrn-search-wrapper">
                                    <input type="text" id="lrn-search-input" name="lrn" placeholder="Type LRN to search..." autocomplete="off" maxlength="12" style="height: 40px; font-size: 15px;">
                                    <div class="lrn-search-dropdown" id="lrnSearchDropdown"></div>
                                </div>
                            </td>
                            <td>
                                <input type="text" name="grade_section" id="grade-section-field" placeholder="e.g., Grade 7 - A" required autocomplete="off">
                            </td>
                        </tr>
                        <tr>
                            <td>FIRST NAME: </td>
                            <td>ADDRESS: </td>
                        </tr>
                        <tr>
                            <td><input type="text" name="first_name" id="first-name-field" required autocomplete="off"> </td>
                            <td><input type="text" name="address" id="address-field" required autocomplete="off"> </td>
                        </tr>
                        <tr>
                            <td>MIDDLE NAME: </td>
                            <td>CONTACT NO.: </td>
                        </tr>
                        <tr>
                            <td><input type="text" name="middle_name" id="middle-name-field" autocomplete="off"> </td>
                            <td><input type="number" name="contact_no" id="contact-field" oninput="if(this.value.length > 11) this.value = this.value.slice(0, 11);" required autocomplete="off"> </td>
                        </tr>
                        <tr>
                            <td>LAST NAME: </td>
                            <td>EMAIL: </td>
                        </tr>
                        <tr>
                            <td><input type="text" name="last_name" id="last-name-field" required autocomplete="off"> </td>
                            <td><input type="email" name="email" id="email-field" required autocomplete="off"> </td>
                        </tr>
                        <tr>
                            <td>PROFILE PICTURE: </td>
                            <td>BIRTH DATE: </td>
                        </tr>
                        <tr>
                            <td><input type="file" name="profile_picture"> </td>
                            <td><input type="date" name="birth_date" id="birth" required autocomplete="off"> </td>
                        </tr>
                        <tr>
                            <td>GENDER: </td>
                            <td>AGE: </td>
                        </tr>
                        <tr>
                            <td><select name="gender" id="gender-field" required>
                                    <option value=""></option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select> </td>
                            <td><input type="number" name="age" id="age" readonly> </td>
                        </tr>
                    </table>
                </div>
                <div class="container">
                    <table>
                        <tr>
                            <th colspan="2">
                                <h4 style="text-align: center;" class="register-label">GUARDIAN INFORMATION</h4>
                            </th>
                        </tr>
                        <tr>
                            <td>GUARDIAN NAME: </td>
                        </tr>
                        <tr>
                            <td><input type="text" name="guardian_name" id="guardian-name-field" required> </td>
                        </tr>
                        <tr>
                            <td>CONTACT NO.: </td>
                        </tr>
                        <tr>
                            <td><input type="number" name="guardian_contact" id="guardian-contact-field" oninput="if(this.value.length > 11) this.value = this.value.slice(0, 11);" required> </td>
                        </tr>
                        <tr>
                            <td>ADDRESS: </td>
                        </tr>
                        <tr>
                            <td><input type="text" name="guardian_address" id="guardian-address-field"> </td>
                        </tr>
                        <tr>
                            <td>EMAIL: </td>
                        </tr>
                        <tr>
                            <td><input type="email" name="guardian_email" id="guardian-email-field"> </td>
                        </tr>
                    </table>
                </div>
                <div class="container">
                    <table>
                        <tr>
                            <th colspan="2">
                                <h4 style="text-align: center;" class="register-label">MEDICAL INFORMATION</h4>
                            </th>
                        </tr>
                        <tr>
                            <td>KNOWN ALLERGIES: </td>
                        </tr>
                        <tr>
                            <td><textarea name="allergies" id=""></textarea> </td>
                        </tr>
                        <tr>
                            <td>EXISTING MEDICAL CONDITIONS: </td>
                        </tr>
                        <tr>
                            <td><textarea name="medical_conditions" id=""></textarea> </td>
                        </tr>
                    </table>
                </div>
                <button type="submit" class="btn btn-success" style="float: right;">Submit</button>
                <button type="reset" class="btn btn-success" id="clearBtn" style="float: right; margin-right: 10px;">Clear</button>
            </form>
        </main>
    </div>


    <script>
        const birthInput = document.getElementById('birth');
        const ageInput = document.getElementById('age');
        const gradeSection = document.querySelector('input[name="grade_section"]');

        // Age calculation
        if (birthInput && ageInput) {
            birthInput.addEventListener('change', function() {
                if (this.value) {
                    const birthDate = new Date(this.value);
                    const today = new Date();
                    let age = today.getFullYear() - birthDate.getFullYear();
                    const monthDiff = today.getMonth() - birthDate.getMonth();

                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                        age--;
                    }

                    ageInput.value = age;
                } else {
                    ageInput.value = '';
                }
            });
        }

        // Grade & Section normalization
        if (gradeSection) {
            gradeSection.addEventListener('blur', function() {
                let normalized = this.value.trim().replace(/\s*-\s*/g, ' - ');
                this.value = normalized;
            });
        }

        // =============================================
        // LRN SEARCH FUNCTIONALITY
        // =============================================
        const lrnSearchInput = document.getElementById('lrn-search-input');
        const lrnDropdown = document.getElementById('lrnSearchDropdown');
        let searchTimeout = null;

        // Listen for input on the LRN search field
        lrnSearchInput.addEventListener('input', function() {
            const lrnValue = this.value.trim();
            clearTimeout(searchTimeout);

            if (lrnValue.length < 3) {
                lrnDropdown.style.display = 'none';
                lrnDropdown.innerHTML = '';
                return;
            }

            // Debounce the search to avoid too many API calls
            searchTimeout = setTimeout(() => {
                fetchLrnResults(lrnValue);
            }, 300);
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!lrnSearchInput.contains(e.target) && !lrnDropdown.contains(e.target)) {
                lrnDropdown.style.display = 'none';
            }
        });

        // Fetch matching students from the sample table via API
        function fetchLrnResults(lrn) {
            fetch('../process/api.php?action=search_sample&lrn=' + encodeURIComponent(lrn))
                .then(response => response.json())
                .then(data => {
                    lrnDropdown.innerHTML = '';

                    if (data.error) {
                        lrnDropdown.innerHTML = '<div class="lrn-no-result">' + data.error + '</div>';
                        lrnDropdown.style.display = 'block';
                        return;
                    }

                    if (!data.students || data.students.length === 0) {
                        lrnDropdown.innerHTML = '<div class="lrn-no-result">No student found with that LRN</div>';
                        lrnDropdown.style.display = 'block';
                        return;
                    }

                    data.students.forEach(function(student) {
                        const item = document.createElement('div');
                        item.className = 'lrn-result-item';
                        item.innerHTML = '<span class="lrn-number">' + student.lrn + '</span> - <span class="lrn-name">' + student.first_name + ' ' + student.middle_name + ' ' + student.last_name + '</span>';
                        item.addEventListener('click', function() {
                            selectSampleStudent(student);
                        });
                        lrnDropdown.appendChild(item);
                    });

                    lrnDropdown.style.display = 'block';
                })
                .catch(error => {
                    console.error('Error searching LRN:', error);
                    lrnDropdown.innerHTML = '<div class="lrn-no-result">Error searching. Please try again.</div>';
                    lrnDropdown.style.display = 'block';
                });
        }

        // Populate form fields when a student is selected from dropdown
        function selectSampleStudent(student) {
            lrnDropdown.style.display = 'none';
            lrnSearchInput.value = student.lrn;

            // Student Information
            // document.getElementById('lrn-field').value = student.lrn || '';
            document.getElementById('first-name-field').value = student.first_name || '';
            document.getElementById('middle-name-field').value = student.middle_name || '';
            document.getElementById('last-name-field').value = student.last_name || '';
            document.getElementById('grade-section-field').value = student.grade_section || '';
            document.getElementById('address-field').value = student.address || '';
            document.getElementById('contact-field').value = student.contact || '';
            document.getElementById('email-field').value = student.email || '';

            // Birth date
            if (student.birth_date) {
                document.getElementById('birth').value = student.birth_date;
                // Trigger age calculation
                birthInput.dispatchEvent(new Event('change'));
            }

            // Gender
            const genderSelect = document.getElementById('gender-field');
            if (student.gender) {
                for (let i = 0; i < genderSelect.options.length; i++) {
                    if (genderSelect.options[i].value === student.gender) {
                        genderSelect.selectedIndex = i;
                        break;
                    }
                }
            }

            // Guardian Information
            document.getElementById('guardian-name-field').value = student.guardian_name || '';
            document.getElementById('guardian-contact-field').value = student.guardian_no || '';
            document.getElementById('guardian-address-field').value = student.guardian_address || '';
            document.getElementById('guardian-email-field').value = student.guardian_email || '';
        }

        // Clear the LRN search and reset all form fields
        function clearLrnSearch() {
            lrnSearchInput.value = '';
            lrnDropdown.style.display = 'none';
            lrnDropdown.innerHTML = '';

            // Clear all form fields
            // document.getElementById('lrn-field').value = '';
            document.getElementById('first-name-field').value = '';
            document.getElementById('middle-name-field').value = '';
            document.getElementById('last-name-field').value = '';
            document.getElementById('grade-section-field').value = '';
            document.getElementById('address-field').value = '';
            document.getElementById('contact-field').value = '';
            document.getElementById('email-field').value = '';
            document.getElementById('birth').value = '';
            document.getElementById('age').value = '';
            document.getElementById('gender-field').selectedIndex = 0;
            document.getElementById('guardian-name-field').value = '';
            document.getElementById('guardian-contact-field').value = '';
            document.getElementById('guardian-address-field').value = '';
            document.getElementById('guardian-email-field').value = '';
        }

        // Allow Enter key to search
        lrnSearchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const lrnValue = this.value.trim();
                if (lrnValue.length >= 3) {
                    fetchLrnResults(lrnValue);
                }
            }
        });
    </script>

    <?php include '../include/footer.php'; ?>
</body>

</html>