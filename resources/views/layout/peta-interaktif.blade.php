<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nusantara BioHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        tailwind.config = {
          theme: {
            extend: {
              colors: {
                green: {
                  primary: '#2E7D32',
                  light: '#4CAF50',
                  pale: '#E8F5E9',
                  dark: '#1B5E20',
                },
                forest: {
                  primary: '#1E4D2B',
                  light: '#2E7D32',
                  pale: '#E8F5E9',
                  dark: '#0E2E1A',
                },
                amber: {
                  accent: '#D97706',
                  light: '#FEF3C7',
                  dark: '#B45309',
                },
                status: {
                  cr: '#B71C1C', // Critically Endangered
                  en: '#E65100', // Endangered
                  vu: '#F57F17', // Vulnerable
                }
              },
              fontFamily: {
                sans: ['Inter', 'system-ui', 'sans-serif'],
              }
            }
          }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .stat-card:hover { transform: translateY(-4px); transition: all 0.3s ease; }
        .species-badge-cr { background: #B71C1C; }
        .species-badge-en { background: #E65100; }
        .species-badge-vu { background: #F57F17; }
        .symptom-btn.active { background: #2E7D32; color: #fff; border-color: #2E7D32; }
        .symptom-btn:hover { background: #2E7D32; color: #fff; border-color: #2E7D32; }
        .map-pin { animation: pulse 2s infinite; }
        @keyframes pulse {
          0%, 100% { transform: scale(1); opacity: 1; }
          50% { transform: scale(1.3); opacity: 0.7; }
        }
        .counter { transition: all 0.5s ease; }
        .herb-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(46,125,50,0.15); transition: all 0.3s ease; }

        /* Color Utility Fallbacks */
        .bg-forest-primary { background-color: #1E4D2B !important; }
        .hover\:bg-forest-dark:hover { background-color: #0E2E1A !important; }
        .text-forest-primary { color: #1E4D2B !important; }
        .bg-forest-pale { background-color: #E8F5E9 !important; }
        .bg-status-cr { background-color: #B71C1C !important; }
        .bg-status-en { background-color: #E65100 !important; }
        .bg-status-vu { background-color: #F57F17 !important; }
        .text-status-cr { color: #B71C1C !important; }
        .text-status-en { color: #E65100 !important; }
        .text-status-vu { color: #F57F17 !important; }
        .text-amber-accent { color: #D97706 !important; }

        /* Spesies & Wizard styles */
        .selector-card:hover { border-color: #1E4D2B; background-color: #F0F7F1; transform: translateY(-2px); transition: all 0.2s ease; }
        .selector-card.active { border-color: #1E4D2B !important; background-color: #F0F7F1 !important; box-shadow: 0 0 0 2px #1E4D2B !important; }
        .selector-card.active div { background-color: #1E4D2B !important; color: #ffffff !important; }
        .selector-card.active i { color: #1E4D2B !important; }
        .selector-card.active div i { color: #ffffff !important; }
        .selector-card.active span { color: #1E4D2B !important; font-weight: 800 !important; }
        .wizard-step { display: none; }
        .wizard-step.active { display: block; animation: fadeIn 0.4s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .report-banner { border-left: 6px solid #B71C1C; }

        /* Detail Spesies styles */
        .tab-btn.active { border-bottom: 3px solid #1E4D2B; color: #1E4D2B; font-weight: 700; }
        .tab-content { display: none; }
        .tab-content.active { display: block; animation: fadeIn 0.3s ease; }
        .danger-box  { border-left: 4px solid #B71C1C; }
        .warning-box { border-left: 4px solid #D97706; }
        .thumb { opacity: 0.6; cursor: pointer; transition: opacity 0.2s, border-color 0.2s; border: 2px solid transparent; }
        .thumb:hover { opacity: 1; }
        .thumb.thumb-active { opacity: 1; border-color: #1E4D2B; }
        #main-img { transition: opacity 0.15s ease; }    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Inter', sans-serif; }
        .map-container { height: calc(100vh - 64px); }
        .sidebar { height: calc(100vh - 64px); }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #E2E8F0; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #CBD5E1; }
        
        .map-pin { 
          cursor: pointer; 
          transition: all 0.2s ease;
          filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
        }
        .map-pin:hover { transform: scale(1.2) translateY(-4px); z-index: 50; }
        
        .status-dot { width: 8px; height: 8px; border-radius: 50%; }
        
        /* Animation for the drawer */
        .drawer-transition { transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .drawer-closed { transform: translateX(100%); }
        .drawer-open { transform: translateX(0); }
    </style>
  
    @stack('styles')
</head>

<body>
    @include('components.header')
    @yield('content')
    @stack('scripts')
</body>

</html>
