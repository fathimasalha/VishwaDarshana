/* =====================================================
   ADMIN PANEL JAVASCRIPT
   File: assets/js/admin.js
   ===================================================== */

// Admin DOM Ready
document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector('.admin-wrapper')) {
        initAdminComponents();
    }
});

function initAdminComponents() {
    initSidebarToggle();
    initAdminDropdowns();
    initDataTables();
    initAdminCharts();
    initModalHandlers();
    initBulkActions();
    initStatusUpdates();
}

// Sidebar Toggle
function initSidebarToggle() {
    const toggleBtn = document.querySelector('.sidebar-toggle');
    const sidebar = document.querySelector('.admin-sidebar');
    
    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
    }
    
    // Submenu Toggle
    const menuItems = document.querySelectorAll('.menu-item.has-submenu');
    menuItems.forEach(item => {
        const link = item.querySelector('.menu-link');
        link.addEventListener('click', function(e) {
            e.preventDefault();
            item.classList.toggle('active');
        });
    });
}

// Admin Dropdowns
function initAdminDropdowns() {
    const dropdowns = document.querySelectorAll('.dropdown');
    
    dropdowns.forEach(dropdown => {
        const toggle = dropdown.querySelector('.dropdown-toggle');
        const menu = dropdown.querySelector('.dropdown-menu');
        
        toggle.addEventListener('click', function(e) {
            e.stopPropagation();
            menu.classList.toggle('active');
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function() {
        document.querySelectorAll('.dropdown-menu.active').forEach(menu => {
            menu.classList.remove('active');
        });
    });
}

// Data Tables
function initDataTables() {
    const tables = document.querySelectorAll('.data-table');
    
    tables.forEach(table => {
        // Add search functionality
        const searchBox = document.createElement('input');
        searchBox.type = 'text';
        searchBox.placeholder = 'Search...';
        searchBox.className = 'table-search';
        
        table.parentElement.insertBefore(searchBox, table);
        
        searchBox.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = table.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
        
        // Sort functionality
        const headers = table.querySelectorAll('th[data-sortable]');
        headers.forEach((header, index) => {
            header.style.cursor = 'pointer';
            header.addEventListener('click', () => sortTable(table, index));
        });
    });
}

// Table Sorting
function sortTable(table, column) {
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    const isAscending = table.dataset.sortOrder !== 'asc';
    
    rows.sort((a, b) => {
        const aText = a.cells[column].textContent.trim();
        const bText = b.cells[column].textContent.trim();
        
        // Check if numeric
        const aNum = parseFloat(aText);
        const bNum = parseFloat(bText);
        
        if (!isNaN(aNum) && !isNaN(bNum)) {
            return isAscending ? aNum - bNum : bNum - aNum;
        }
        
        return isAscending ? 
            aText.localeCompare(bText) : 
            bText.localeCompare(aText);
    });
    
    rows.forEach(row => tbody.appendChild(row));
    table.dataset.sortOrder = isAscending ? 'asc' : 'desc';
}

// Admin Charts
function initAdminCharts() {
    // Placeholder for chart initialization
    // You can use Chart.js or any other library here
}

// Modal Handlers
function initModalHandlers() {
    // Open modal
    document.querySelectorAll('[data-toggle="modal"]').forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            const modalId = this.getAttribute('data-target');
            const modal = document.querySelector(modalId);
            if (modal) {
                modal.classList.add('active');
            }
        });
    });
    
    // Close modal
    document.querySelectorAll('.modal-close, [data-dismiss="modal"]').forEach(closer => {
        closer.addEventListener('click', function() {
            const modal = this.closest('.modal');
            if (modal) {
                modal.classList.remove('active');
            }
        });
    });
    
    // Close on outside click
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.remove('active');
            }
        });
    });
}

// Bulk Actions
function initBulkActions() {
    const selectAll = document.getElementById('selectAll');
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    }
    
    const bulkActionBtn = document.getElementById('bulkActionBtn');
    if (bulkActionBtn) {
        bulkActionBtn.addEventListener('click', function() {
            const action = document.getElementById('bulkAction').value;
            const selected = document.querySelectorAll('.item-checkbox:checked');
            
            if (selected.length === 0) {
                alert('Please select at least one item');
                return;
            }
            
            if (confirm(`Are you sure you want to ${action} ${selected.length} items?`)) {
                // Perform bulk action
                performBulkAction(action, selected);
            }
        });
    }
}

// Status Updates
function initStatusUpdates() {
    document.querySelectorAll('.status-update').forEach(select => {
        select.addEventListener('change', function() {
            const id = this.dataset.id;
            const status = this.value;
            
            if (confirm('Are you sure you want to update the status?')) {
                updateStatus(id, status);
            } else {
                // Reset to original value
                this.value = this.dataset.original;
            }
        });
    });
}

// AJAX Functions
function updateStatus(id, status) {
    fetch(`${SITE_URL}/ajax/update-status.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id, status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAdminMessage('success', 'Status updated successfully');
        } else {
            showAdminMessage('error', data.message || 'Failed to update status');
        }
    })
    .catch(error => {
        showAdminMessage('error', 'An error occurred');
        console.error('Error:', error);
    });
}

function performBulkAction(action, items) {
    const ids = Array.from(items).map(item => item.value);
    
    fetch(`${SITE_URL}/ajax/bulk-action.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ action, ids })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAdminMessage('success', data.message);
            setTimeout(() => location.reload(), 1500);
        } else {
            showAdminMessage('error', data.message || 'Operation failed');
        }
    });
}

// Admin Message Display
function showAdminMessage(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
        ${message}
    `;
    
    const content = document.querySelector('.admin-content');
    content.insertBefore(alertDiv, content.firstChild);
    
    setTimeout(() => alertDiv.remove(), 5000);
}

// Print Function
function printContent(elementId) {
    const content = document.getElementById(elementId);
    const printWindow = window.open('', '', 'height=600,width=800');
    
    printWindow.document.write('<html><head><title>Print</title>');
    printWindow.document.write('<link rel="stylesheet" href="' + SITE_URL + '/assets/css/admin.css">');
    printWindow.document.write('</head><body>');
    printWindow.document.write(content.innerHTML);
    printWindow.document.write('</body></html>');
    
    printWindow.document.close();
    printWindow.focus();
    
    setTimeout(() => {
        printWindow.print();
        printWindow.close();
    }, 250);
}

// Export Function
function exportData(format) {
    const params = new URLSearchParams(window.location.search);
    params.set('export', format);
    
    window.location.href = `${window.location.pathname}?${params.toString()}`;
}