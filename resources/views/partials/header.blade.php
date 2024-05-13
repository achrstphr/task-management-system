<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
  <script src="//unpkg.com/alpinejs" defer></script>
  <title>Task Management System</title>

</head>
<body class="bg-gradient-to-t from-[#686e74] to-[#103142] h-screen">
  <header class="bg-gray-800 md:sticky top-0 z-50">
    <x-nav />     
  </header>
  <script>
    const navLinks = document.querySelector('.nav-links');
    const header = document.querySelector('header');

    function onToggleMenu(icon) {
        const iconName = icon.getAttribute('name');

        // Toggle the name of the icon
        icon.setAttribute('name', iconName === 'menu' ? 'close' : 'menu');

        // Toggle the top margin of the nav-links
        navLinks.classList.toggle('top-[9%]');
        
        // Toggle the sticky behavior of the header
        if (iconName === 'close') {
            header.classList.remove('sticky');
        } else {
            header.classList.add('sticky');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        var userDropdown = document.getElementById('userDropdown');
        var userDropdownMenu = document.getElementById('userDropdownMenu');

        userDropdown.addEventListener('click', function () {
            userDropdownMenu.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function (event) {
            if (!userDropdown.contains(event.target)) {
                userDropdownMenu.classList.add('hidden');
            }
        });
    });

  
  </script>
  <x-messages />