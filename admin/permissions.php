<?php
function isAdmin() {
    return isset($_SESSION['Role']) && $_SESSION['Role'] === 'Admin';
}

function isStaff() {
    return isset($_SESSION['Role']) && $_SESSION['Role'] === 'Staff';
}

function canView() {
    return isAdmin() || isStaff();
}

function canEdit() {
    return isAdmin();
}

function canDelete() {
    return isAdmin();
}

function canCreate() {
    return isAdmin();
}
?>