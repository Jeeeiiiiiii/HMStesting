<!DOCTYPE html>
<html lang="en" class= "scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ospital ni joel</title>
    @vite('resources/css/app.css') <!-- Link to your Tailwind CSS file -->
    <script src="https://cdn.tailwindcss.com"></script> <!-- Optionally include Tailwind CDN -->
</head>
<body class="bg-gray-50">

    <header class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center">
                    <img src="logo.jpg" alt="Logo" class="h-8 w-8 object-contain" />
                <span class="ml-2 text-xl font-bold text-gray-800">Ospital ng Parañaque</span>
            </div>
            <nav class="hidden md:flex space-x-4 flex-wrap">
                <a href="#home" class="text-gray-800 hover:text-primary">Home</a>
                <a href="#services" class="text-gray-800 hover:text-primary">Services</a>
                <a href="#about" class="text-gray-800 hover:text-primary">About</a>
                <a href="#contact" class="text-gray-800 hover:text-primary">Contact</a>
                <div class="px-8">
                    <a href="{{ route('login') }}" class="text-gray-800 hover:text-primary ml-4">Login</a>
                </div>
            </nav>
            <button class="md:hidden" onclick="toggleMenu()">
                <span id="menu-icon">Menu</span>
            </button>
        </div>
        <nav id="mobile-menu" class="md:hidden bg-white px-4 py-2 flex flex-col space-y-2 hidden">
            <a href="#home" class="text-gray-800 hover:text-primary">Home</a>
            <a href="#services" class="text-gray-800 hover:text-primary">Services</a>
            <a href="#about" class="text-gray-800 hover:text-primary">About</a>
            <a href="#contact" class="text-gray-800 hover:text-primary">Contact</a>
            <a href="{{ route('login') }}" class="bg-primary text-gray px-4 py-2 rounded">Login</a>
        </nav>
    </header>

    <main>
        <section id= "home" class="bg-primary text-primary-foreground py-20">
            <div class="container mx-auto px-4 flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-8 md:mb-0">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">Your Health, Our Priority</h1>
                    <p class="text-xl mb-6">Experience world-class healthcare with compassionate experts.</p>
                    <p class="text-xl mb-6">As the only government hospital in the city of Parañaque, Ospital ng Parañaque ensures that its healthcare services are at par with the nine private hospitals in the city. Ospital ng Parañaque boasts a 6-story building with specialized services in Dermatology, Ophthalmology, and Obstetrics-Gynecology. Additional diagnostic services available include Laboratory, Pharmacy, X-Ray, and Breastfeeding Stations.</p>
                </div>
                <div class="md:w-1/2">
                    <img src="lahuerta.jpg" alt="Hospital Staff" class="rounded-lg shadow-lg" width="600" height="400">
                </div>
            </div>
        </section>

        <section id= "services" class="py-20">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center mb-12">Our Services</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach ([
                        'Emergency Care' => 'Providing immediate assistance and support for critical health situations. Our team is dedicated to addressing urgent medical needs with efficiency and compassion.',
                        'Specialized Treatments' => 'Offering targeted care and support for specific health issues. Our team is committed to meeting urgent medical requirements with effectiveness and empathy.',
                        'Preventive Health' => 'Focusing on measures to prevent illnesses and promote overall health. We provide screenings, vaccinations, and wellness programs to ensure your well-being.'
                    ] as $service => $description)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-2">{{ $service }}</h3>
                            <p class="text-muted-foreground mb-4">
                                {{ $description }}
                            </p>
                            <a href="#" class="border border-primary text-primary px-4 py-2 rounded">Learn More</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>


        <section id="about" class="bg-gray-100 py-20">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center mb-12">Patient Process Guide</h2>
                <div class="grid grid-cols-1 md:grid-cols-5 gap-8">
                    @foreach ([
                        ['step' => '1', 'title' => 'Triage', 'description' => 'The initial assessment where patients are evaluated and categorized based on the urgency of their condition.'],
                        ['step' => '2', 'title' => 'ER', 'description' => 'Immediate care for emergency cases is provided in the Emergency Room, stabilizing the patient.'],
                        ['step' => '3', 'title' => 'Lab', 'description' => 'Patients undergo diagnostic tests, including blood tests, X-rays, or scans as prescribed by the doctor.'],
                        ['step' => '4', 'title' => 'Admit', 'description' => 'After diagnosis, patients may be admitted for further treatment or observation in the hospital.'],
                        ['step' => '5', 'title' => 'Clearance', 'description' => 'Once treatment is complete, patients receive discharge instructions and necessary clearances before going home.']
                    ] as $step)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <div class="p-6 text-center">
                            <div class="mb-4">
                                <div class="text-4xl font-bold text-primary mb-2">{{ $step['step'] }}</div>
                                <h3 class="text-xl font-semibold">{{ $step['title'] }}</h3>
                            </div>
                            <p class="text-muted-foreground mb-4">{{ $step['description'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="flex justify-center mt-8">
                    <div class="w-full md:w-1/2">
                        <div class="relative pt-1">
                            <div class="overflow-hidden h-2 text-xs flex bg-primary-foreground bg-opacity-20 rounded">
                                <div style="width: 100%" class="bg-primary-foreground shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center"></div>
                            </div>
                            <div class="text-center mt-4">
                                <span class="text-2xl font-bold text-primary ">Process Complete</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section id= "contact" class="py-20">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center mb-12">Contact Us</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <form class="space-y-4">
                            <input type="text" class="w-full p-3 border rounded-md" placeholder="Your Name" />
                            <input type="email" class="w-full p-3 border rounded-md" placeholder="Your Email" />
                            <input type="text" class="w-full p-3 border rounded-md" placeholder="Subject" />
                            <textarea class="w-full p-3 border rounded-md" rows="4" placeholder="Your Message"></textarea>
                            <button type="submit" class="bg-primary text-white px-4 py-2 rounded">Send Message</button>
                        </form>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 mr-2 text-primary" fill="none" viewBox="0 0 24 24"><path d="M12 2a10 10 0 100 20 10 10 0 000-20zm2 15h-4v-2h4v2zm0-4h-4V7h4v6z" /></svg>
                            <span>+1 (555) 123-4567</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="h-5 w-5 mr-2 text-primary" fill="none" viewBox="0 0 24 24"><path d="M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2s10 4.477 10 10zm-15 0h6v2h-6v-2z" /></svg>
                            <span>ospitalngparanaque@yahoo.com</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="h-5 w-5 mr-2 text-primary" fill="none" viewBox="0 0 24 24"><path d="M20 12c0 4.418-3.582 8-8 8s-8-3.582-8-8 3.582-8 8-8 8 3.582 8 8zm-2 0c0-3.313-2.687-6-6-6S6 8.687 6 12s2.687 6 6 6 6-2.687 6-6z" /></svg>
                            <span>440 Quirino Ave. Brgy La Huerta 1700 Parañaque, Philippines</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-gray-900 text-white py-6">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; 2024 Ospital ng Parañaque. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function toggleMenu() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
            document.getElementById('menu-icon').textContent = document.getElementById('mobile-menu').classList.contains('hidden') ? 'Menu' : 'Close';
        }
    </script>
</body>
</html>
