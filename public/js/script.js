/**
 * Manage mobile nav
 */
const closeNav = document.querySelector("#closeNav");
const toggleNav = document.querySelector("#toggleNav");
const sidebar = document.querySelector("#sidebar");

closeNav.addEventListener('click', function() {
    sidebar.classList.add('hidden');
});

toggleNav.addEventListener('click', function() {
    sidebar.classList.remove('hidden');
});
