<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nusantara BioHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    body { font-family: 'Inter', 'Segoe UI', sans-serif; }
    .sidebar-active { background: #1E4D2B; color: #fff; }
    .sidebar-item:hover { background: rgba(255,255,255,0.08); }
    .sidebar-item { transition: background 0.15s; }
    .scrollbar-thin::-webkit-scrollbar { width: 4px; }
    .scrollbar-thin::-webkit-scrollbar-thumb { background: #2d6a3f; border-radius: 4px; }
    #reject-modal { display: none; }
    #reject-modal.open { display: flex; }
  </style>
</head>
<body>
    @yield('content')
    @stack('scripts')
</body>
</html>