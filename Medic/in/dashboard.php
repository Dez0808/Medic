<!DOCTYPE html>
<html lang="en">
<?php session_start(); ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../js/bootstrap.bundle.min.js" />
    <link rel="icon" type="image/x-icon" href="../Pics/Logos/Lagro_High_School_logo.png">
    <title>Dashboard</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        main {
            display: flex;
        }

        .container {
            flex: 1;
            padding: 24px;
        }

        /* ===== Overview Section ===== */
        .overview-section {
            margin-bottom: 28px;
        }

        .overview-section h2 {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 16px;
        }

        .stats-row {
            display: flex;
            gap: 16px;
            margin-bottom: 20px;
        }

        .stat-box {
            flex: 1;
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
        }

        .stat-box .stat-label {
            font-size: 13px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .stat-box .stat-number {
            font-size: 32px;
            font-weight: 700;
            color: black;
        }

        .stat-box.highlight {
            background: var(--gradient-color);
        }

        .stat-box.highlight .stat-label {
            color: #a0a0b8;
        }

        .stat-box.highlight .stat-number {
            color: #fff;
        }

        /* ===== Illness Cards ===== */
        .illness-grid {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        .illness-card {
            flex: 1;
            min-width: 150px;
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 18px 16px;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .illness-card:hover {
            border-color: #1a1a2e;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .illness-card .rank {
            font-size: 11px;
            font-weight: 600;
            color: #fff;
            background: var(--gradient-color);
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .illness-card .illness-name {
            font-size: 15px;
            font-weight: 600;
            color: black;
            margin-bottom: 4px;
            text-transform: uppercase;
        }

        .illness-card .illness-count {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a2e;
        }

        .illness-card .illness-percent {
            font-size: 13px;
            color: #888;
            margin-top: 2px;
        }

        .illness-card .hover-info {
            display: none;
            font-size: 13px;
            color: #555;
            margin-top: 4px;
        }

        .illness-card:hover .illness-percent {
            display: none;
        }

        .illness-card:hover .hover-info {
            display: block;
        }

        .no-data-msg {
            color: #999;
            font-style: italic;
            padding: 20px 0;
        }

        /* ===== Table Section ===== */

        .table-section h2 {
            font-size: 20px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 16px;
        }

        .table-container {
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead {
            background: var(--gradient-color);
        }

        table thead th {
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 14px 16px;
            text-align: left;
        }

        table tbody tr {
            border-bottom: 1px solid #f0f0f0;
            transition: background 0.15s ease;
        }

        table tbody tr:hover {
            background: #f8f8fb;
        }

        table tbody td {
            padding: 12px 16px;
            font-size: 14px;
            color: #333;
        }

        .badge-status {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-confined {
            background: #fff3e0;
            color: #e65100;
        }

        .badge-discharged {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .btn-view {
            background: #fff;
            color: #1a1a2e;
            border: 1.5px solid black;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-right: 6px;
        }

        .btn-view:hover {
            background: green;
            color: #fff;
        }

        .btn-discharge {
            background: darkgreen;
            color: #fff;
            border: none;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .btn-discharge:hover {
            background: green;
        }

        .btn-discharge:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .loading-text {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        /* ===== Modal Overlay ===== */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.45);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-box {
            background: #fff;
            border-radius: 12px;
            width: 100%;
            max-width: 460px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            animation: modalSlideIn 0.2s ease;
            overflow: hidden;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(10px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            font-size: 17px;
            font-weight: 700;
            color: #1a1a2e;
            margin: 0;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 22px;
            cursor: pointer;
            color: #999;
            padding: 0;
            line-height: 1;
            transition: color 0.15s ease;
        }

        .modal-close:hover {
            color: #333;
        }

        .modal-body {
            padding: 24px;
        }

        .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        /* View Modal Info Rows */
        .info-row {
            display: flex;
            padding: 11px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            width: 140px;
            font-size: 13px;
            font-weight: 600;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            flex-shrink: 0;
        }

        .info-value {
            flex: 1;
            font-size: 14px;
            color: #1a1a2e;
            font-weight: 500;
        }

        /* Discharge Form */
        .discharge-form .form-group {
            margin-bottom: 16px;
        }

        .discharge-form .form-group:last-child {
            margin-bottom: 0;
        }

        .discharge-form label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #555;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .discharge-form input,
        .discharge-form select {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            font-family: Arial, sans-serif;
            color: #333;
            background: #fafafa;
            transition: border-color 0.2s ease;
        }

        .discharge-form input:focus,
        .discharge-form select:focus {
            outline: none;
            border-color: #1a1a2e;
            background: #fff;
        }

        .btn-modal-cancel {
            background: #fff;
            color: #666;
            border: 1px solid #ddd;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .btn-modal-cancel:hover {
            background: #f5f5f5;
            border-color: #ccc;
        }

        .btn-modal-confirm {
            background: darkgreen;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s ease;
        }

        .btn-modal-confirm:hover {
            background: green;
        }

        .btn-modal-confirm:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>

<body>
    <main>
        <div class="sidebar-container">
            <?php include "../include/sidebar.php" ?>
        </div>
        <div class="container">

            <!-- Overview Section -->
            <div class="overview-section">
                <h2>Dashboard</h2>

                <div class="stats-row">
                    <div class="stat-box highlight">
                        <div class="stat-label">Total Confined</div>
                        <div class="stat-number" id="totalConfined">0</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-label">Currently Confined</div>
                        <div class="stat-number" id="currentlyConfined">0</div>
                    </div>
                </div>

                <div class="illness-grid" id="illnessGrid">
                    <div class="loading-text">Loading illness data...</div>
                </div>
            </div>

            <!-- Patients Table Section -->
            <div class="table-section">
                <h2>History</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Patient Name</th>
                                <th>Illness</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="patientsTableBody">
                            <tr>
                                <td colspan="8" class="loading-text">Loading patients...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <!-- View Patient Modal -->
    <div class="modal-overlay" id="viewModal">
        <div class="modal-box">
            <div class="modal-header">
                <h3>Patient Details</h3>
                <button class="modal-close" onclick="closeViewModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="info-row">
                    <div class="info-label">Name: </div>
                    <div class="info-value" id="viewName">-</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Grade & Section: </div>
                    <div class="info-value" id="viewGradeSection">-</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Age: </div>
                    <div class="info-value" id="viewAge">-</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Gender: </div>
                    <div class="info-value" id="viewGender">-</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Contact No. </div>
                    <div class="info-value" id="viewContact">-</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Visits: </div>
                    <div class="info-value" id="viewVisits">-</div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-modal-cancel" onclick="closeViewModal()">Close</button>
            </div>
        </div>
    </div>

    <!-- Discharge Patient Modal -->
    <div class="modal-overlay" id="dischargeModal">
        <div class="modal-box">
            <div class="modal-header">
                <h3>Discharge Patient</h3>
                <button class="modal-close" onclick="closeDischargeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <p style="font-size: 14px; color: #555; margin-bottom: 20px;">
                    Discharging: <strong id="dischargePatientName">-</strong>
                </p>
                <div class="discharge-form">
                    <div class="form-group">
                        <label for="guardianName">Guardian's Name</label>
                        <input type="text" id="guardianName" placeholder="Enter guardian's full name">
                    </div>
                    <div class="form-group">
                        <label for="guardianContact">Contact No.</label>
                        <input type="text" id="guardianContact" placeholder="Enter contact number">
                    </div>
                    <div class="form-group">
                        <label for="guardianAddress">Address</label>
                        <input type="text" id="guardianAddress" placeholder="Enter address">
                    </div>
                    <div class="form-group">
                        <label for="guardianRelationship">Relationship</label>
                        <select id="guardianRelationship">
                            <option value="" disabled selected>Select relationship</option>
                            <option value="Mother">Mother</option>
                            <option value="Father">Father</option>
                            <option value="Guardian">Guardian</option>
                            <option value="Sibling">Sibling</option>
                            <option value="Relative">Relative</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-modal-cancel" onclick="closeDischargeModal()">Cancel</button>
                <button class="btn-modal-confirm" id="btnConfirmDischarge" onclick="confirmDischarge()">Confirm Discharge</button>
            </div>
        </div>
    </div>

    <?php include "../include/footer.php"; ?>

    <script>
        // Store patients data globally for modal access
        let patientsData = [];
        let dischargeConfinedId = null;

        // Animate a number counting up
        function animateCounter(elementId, start, end, duration) {
            const el = document.getElementById(elementId);
            if (!el) return;
            const range = end - start;
            if (range === 0) {
                el.textContent = end;
                return;
            }
            const increment = range / (duration / 16);
            let current = start;
            const timer = setInterval(() => {
                current += increment;
                if (current >= end) {
                    el.textContent = end;
                    clearInterval(timer);
                } else {
                    el.textContent = Math.floor(current);
                }
            }, 16);
        }

        // Format datetime string
        function formatDate(dt) {
            if (!dt || dt === '0000-00-00 00:00:00') return '-';
            const d = new Date(dt);
            return d.toLocaleString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric',
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            });
        }

        /* ===== View Modal ===== */
        function openViewModal(confinedId) {
            const p = patientsData.find(pt => pt.confined_id == confinedId);
            if (!p) return;

            const fullName = [p.first_name, p.middle_name, p.last_name].filter(Boolean).join(' ');
            document.getElementById('viewName').textContent = fullName || '-';
            document.getElementById('viewGradeSection').textContent = p.grade_section || '-';
            document.getElementById('viewAge').textContent = p.age || '-';
            document.getElementById('viewGender').textContent = p.gender || '-';
            document.getElementById('viewContact').textContent = p.student_no || '-';
            document.getElementById('viewVisits').textContent = p.visits || '-';

            document.getElementById('viewModal').classList.add('active');
        }

        function closeViewModal() {
            document.getElementById('viewModal').classList.remove('active');
        }

        /* ===== Discharge Modal ===== */
        function openDischargeModal(confinedId) {
            const p = patientsData.find(pt => pt.confined_id == confinedId);
            if (!p) return;

            dischargeConfinedId = confinedId;
            const fullName = [p.first_name, p.middle_name, p.last_name].filter(Boolean).join(' ');
            document.getElementById('dischargePatientName').textContent = fullName;

            // Reset form
            document.getElementById('guardianName').value = '';
            document.getElementById('guardianContact').value = '';
            document.getElementById('guardianAddress').value = '';
            document.getElementById('guardianRelationship').value = '';
            document.getElementById('btnConfirmDischarge').disabled = false;
            document.getElementById('btnConfirmDischarge').textContent = 'Confirm Discharge';

            document.getElementById('dischargeModal').classList.add('active');
        }

        function closeDischargeModal() {
            document.getElementById('dischargeModal').classList.remove('active');
            dischargeConfinedId = null;
        }

        function confirmDischarge() {
            if (!dischargeConfinedId) return;

            const guardianName = document.getElementById('guardianName').value.trim();
            const guardianContact = document.getElementById('guardianContact').value.trim();
            const guardianAddress = document.getElementById('guardianAddress').value.trim();
            const guardianRelationship = document.getElementById('guardianRelationship').value;

            if (!guardianName || !guardianContact || !guardianAddress || !guardianRelationship) {
                alert('Please fill in all guardian fields.');
                return;
            }

            const btn = document.getElementById('btnConfirmDischarge');
            btn.disabled = true;
            btn.textContent = 'Discharging...';

            const formData = new FormData();
            formData.append('action', 'discharge_patient');
            formData.append('confined_id', dischargeConfinedId);
            formData.append('guardians_name', guardianName);
            formData.append('contact_no', guardianContact);
            formData.append('address', guardianAddress);
            formData.append('relationship', guardianRelationship);

            fetch('../process/api.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert('Patient discharged successfully.');
                        closeDischargeModal();
                        loadDashboard();
                    } else {
                        alert(data.error || 'Failed to discharge patient.');
                        btn.disabled = false;
                        btn.textContent = 'Confirm Discharge';
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Error discharging patient.');
                    btn.disabled = false;
                    btn.textContent = 'Confirm Discharge';
                });
        }

        // Close modals on overlay click
        document.getElementById('viewModal').addEventListener('click', function(e) {
            if (e.target === this) closeViewModal();
        });
        document.getElementById('dischargeModal').addEventListener('click', function(e) {
            if (e.target === this) closeDischargeModal();
        });

        // Close modals on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeViewModal();
                closeDischargeModal();
            }
        });

        /* ===== Load Dashboard ===== */
        function loadDashboard() {
            fetch('../process/api.php?action=get_dashboard_stats')
                .then(res => res.json())
                .then(data => {
                    if (data.error) {
                        console.error(data.error);
                        return;
                    }

                    animateCounter('totalConfined', 0, data.total_confined, 1200);
                    animateCounter('currentlyConfined', 0, data.currently_confined, 1200);

                    const grid = document.getElementById('illnessGrid');
                    const illnesses = data.top_illnesses;

                    if (!illnesses || illnesses.length === 0) {
                        grid.innerHTML = '<div class="no-data-msg">No illness data available yet.</div>';
                    } else {
                        const totalTop = illnesses.reduce((s, i) => s + parseInt(i.count), 0);
                        grid.innerHTML = '';

                        illnesses.forEach((item, idx) => {
                            const pct = totalTop > 0 ? Math.round((parseInt(item.count) / totalTop) * 100) : 0;
                            const card = document.createElement('div');
                            card.className = 'illness-card';
                            card.innerHTML = `
                                <span class="rank">#${idx + 1}</span>
                                <div class="illness-name">${item.illness}</div>
                                <div class="illness-count">${item.count}</div>
                                <div class="illness-percent">${pct}%</div>
                                <div class="hover-info">${item.count} case${item.count > 1 ? 's' : ''} recorded</div>
                            `;
                            card.addEventListener('click', () => {
                                alert(item.illness + ': ' + item.count + ' cases (' + pct + '%)');
                            });
                            grid.appendChild(card);
                        });
                    }

                    patientsData = data.patients || [];

                    const tbody = document.getElementById('patientsTableBody');

                    if (patientsData.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="8" class="loading-text">No confined patients found.</td></tr>';
                    } else {
                        tbody.innerHTML = '';
                        patientsData.forEach(p => {
                            const fullName = [p.first_name, p.middle_name, p.last_name].filter(Boolean).join(' ');
                            const isDischarged = p.discharged && p.discharged !== '0000-00-00 00:00:00';
                            const statusBadge = isDischarged ?
                                '<span class="badge-status badge-discharged">Discharged</span>' :
                                '<span class="badge-status badge-confined">Confined</span>';

                            const viewBtn = `<button class="btn-view" onclick="openViewModal(${p.confined_id})">View</button>`;
                            const dischargeBtn = isDischarged ?
                                '<button class="btn-discharge" disabled>Discharged</button>' :
                                `<button class="btn-discharge" onclick="openDischargeModal(${p.confined_id})">Discharge</button>`;

                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td>${fullName}</td>
                                <td style="text-transform: uppercase;">${p.illness || '-'}</td>
                                <td>${formatDate(p.confinement)}</td>
                                <td>${formatDate(p.discharged)}</td>
                                <td>${statusBadge}</td>
                                <td>${viewBtn}${dischargeBtn}</td>
                            `;
                            tbody.appendChild(tr);
                        });
                    }
                })
                .catch(err => {
                    console.error('Failed to load dashboard:', err);
                    document.getElementById('illnessGrid').innerHTML = '<div class="no-data-msg">Failed to load data.</div>';
                    document.getElementById('patientsTableBody').innerHTML = '<tr><td colspan="8" class="loading-text">Failed to load patients.</td></tr>';
                });
        }

        // Initialize
        window.addEventListener('load', loadDashboard);
    </script>
</body>

</html>