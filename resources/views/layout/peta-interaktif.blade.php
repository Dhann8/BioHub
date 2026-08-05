<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Peta Interaktif Keanekaragaman Hayati - Nusantara BioHub</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    
    <!-- Leaflet GIS Map Library -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        .map-container { height: calc(100vh - 64px); }
        .sidebar { height: calc(100vh - 64px); }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #E2E8F0; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #CBD5E1; }

        /* Color Utility Fallbacks */
        .bg-forest-primary { background-color: #1E4D2B !important; }
        .hover\:bg-forest-dark:hover { background-color: #0E2E1A !important; }
        .text-forest-primary { color: #1E4D2B !important; }
        .bg-forest-pale { background-color: #E8F5E9 !important; }
        .bg-status-cr { background-color: #B71C1C !important; }
        .bg-status-en { background-color: #E65100 !important; }
        .bg-status-vu { background-color: #F57F17 !important; }
        .bg-status-nt { background-color: #65A30D !important; }
        .bg-status-lc { background-color: #1B5E20 !important; }
        .border-status-cr { border-color: #B71C1C !important; }
        .border-status-en { border-color: #E65100 !important; }
        .border-status-vu { border-color: #F57F17 !important; }
        .border-status-nt { border-color: #65A30D !important; }
        .border-status-lc { border-color: #1B5E20 !important; }
        .text-status-cr { color: #B71C1C !important; }
        .text-status-en { color: #E65100 !important; }
        .text-status-vu { color: #F57F17 !important; }
        .text-status-nt { color: #65A30D !important; }
        .text-status-lc { color: #1B5E20 !important; }
        .text-amber-accent { color: #D97706 !important; }

        /* Custom Leaflet Map Styling */
        #map { width: 100%; height: 100%; z-index: 1; outline: none; background: #e5f0f8; }
        .leaflet-container { font-family: 'Inter', sans-serif !important; }
        
        /* Custom Marker Pins */
        .custom-map-pin {
            position: relative;
            cursor: pointer;
            transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
            filter: drop-shadow(0 6px 12px rgba(0,0,0,0.22));
        }
        .custom-map-pin:hover {
            transform: scale(1.22) translateY(-6px);
            z-index: 9999 !important;
        }
        .pin-avatar {
            width: 44px;
            height: 44px;
            border-radius: 9999px;
            overflow: hidden;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            border-width: 3px;
            border-style: solid;
        }
        .pin-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .pin-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            width: 15px;
            height: 15px;
            border-radius: 9999px;
            border: 2px solid #ffffff;
        }
        .pin-pulse {
            position: absolute;
            inset: -4px;
            border-radius: 9999px;
            opacity: 0.7;
            animation: pinPulse 2s infinite ease-in-out;
            pointer-events: none;
        }
        @keyframes pinPulse {
            0% { transform: scale(0.9); opacity: 0.8; }
            50% { transform: scale(1.35); opacity: 0; }
            100% { transform: scale(0.9); opacity: 0; }
        }

        /* Custom Leaflet Popup */
        .leaflet-popup-content-wrapper {
            padding: 0 !important;
            border-radius: 16px !important;
            box-shadow: 0 20px 35px -5px rgba(0, 0, 0, 0.25), 0 10px 15px -5px rgba(0, 0, 0, 0.1) !important;
            overflow: hidden;
            border: 1px solid #f1f5f9;
        }
        .leaflet-popup-content {
            margin: 0 !important;
            line-height: normal !important;
        }
        .leaflet-popup-tip {
            box-shadow: 0 10px 15px -5px rgba(0, 0, 0, 0.1) !important;
        }

        /* Animation for the drawer */
        .drawer-transition { transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1); }
        .drawer-closed { transform: translateX(100%); }
        .drawer-open { transform: translateX(0); }

        /* Biogeography Tooltip & Hotspots */
        .biogeo-tooltip {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(4px) !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 12px !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15) !important;
            padding: 8px 12px !important;
        }
        .custom-hotspot-pin {
            background: transparent !important;
            border: none !important;
        }
        .z-60 { z-index: 60 !important; }

        /* Toast notification */
        #toast-notification {
            transition: all 0.3s ease;
        }
    </style>
  
    @stack('styles')
</head>

<body class="bg-gray-50 overflow-hidden select-none">
    @include('components.header')
    @yield('content')

    <!-- Toast Notification for Actions like Bookmark -->
    <div id="toast-notification" class="fixed bottom-6 left-1/2 -translate-x-1/2 bg-gray-900/90 text-white backdrop-blur-md px-5 py-3 rounded-2xl shadow-2xl z-50 flex items-center gap-3 text-xs font-semibold opacity-0 pointer-events-none transform translate-y-4">
        <i id="toast-icon" class="fa-solid fa-circle-check text-emerald-400 text-sm"></i>
        <span id="toast-message">Notifikasi</span>
    </div>

    @stack('scripts')
</body>

</html>
