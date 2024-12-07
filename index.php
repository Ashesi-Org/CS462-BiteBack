<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoMomentum</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-green: #097969;
            --secondary-green: #20B2AA;
            --accent-blue: #4FB0C6;
            --background-light: #F0F4F4;
            --white: #FFFFFF;
            --dark-text: #2C3E50;
            --shadow: rgba(0,0,0,0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--dark-text);
            background-color: var(--background-light);
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* Navbar */
        .navbar {
            background: var(--white);
            box-shadow: 0 2px 15px var(--shadow);
            padding: 15px 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .navbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo {
            display: flex;
            align-items: center;
            font-weight: 700;
            color: var(--primary-green);
            font-size: 1.5rem;
        }

        .nav-links {
            display: flex;
            gap: 30px;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--dark-text);
            font-weight: 500;
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: var(--secondary-green);
            transition: width 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--secondary-green);
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary-green), var(--accent-blue));
            color: var(--white);
            text-align: center;
            padding: 200px 0 150px;
            margin-top: 70px;
        }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .hero p {
            max-width: 800px;
            margin: 0 auto 30px;
            font-size: 1.2rem;
        }

        .cta-button {
            display: inline-block;
            background: var(--secondary-green);
            color: var(--white);
            padding: 12px 35px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .cta-button:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        /* Impact Counter */
        .impact-counter {
            background: linear-gradient(135deg, var(--primary-green), var(--accent-blue));
            color: var(--white);
            padding: 80px 0;
            text-align: center;
        }

        .counter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 40px;
            max-width: 1100px;
            margin: 0 auto;
        }

        .counter-item {
            background: rgba(255,255,255,0.1);
            padding: 40px;
            border-radius: 15px;
            transition: all 0.4s ease;
        }

        .counter-item:hover {
            transform: scale(1.05);
            background: rgba(255,255,255,0.2);
        }

        .counter-number {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 15px;
        }

        /* Newsletter */
        .newsletter {
            background: var(--white);
            padding: 80px 0;
            text-align: center;
        }

        .newsletter-form {
            max-width: 600px;
            margin: 30px auto 0;
            display: flex;
            box-shadow: 0 10px 30px var(--shadow);
            border-radius: 50px;
            overflow: hidden;
        }

        .newsletter-form input {
            flex-grow: 1;
            padding: 20px;
            border: 1px solid #e0e0e0;
            font-size: 1rem;
        }

        .newsletter-form button {
            background: var(--secondary-green);
            color: var(--white);
            border: none;
            padding: 0 40px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .newsletter-form button:hover {
            background: var(--primary-green);
        }

        /* Social Proof */
        .social-proof {
            background: var(--background-light);
            padding: 80px 0;
            text-align: center;
        }

        .partners-grid {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 40px;
            opacity: 0.7;
        }

        .partners-grid img {
            max-height: 100px;
            filter: grayscale(100%);
            transition: all 0.4s ease;
        }

        .partners-grid img:hover {
            filter: grayscale(0%);
            transform: scale(1.1);
        }

        /* Footer */
        footer {
            background: var(--primary-green);
            color: var(--white);
            text-align: center;
            padding: 30px 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar-content {
                flex-direction: column;
                gap: 15px;
            }

            .nav-links {
                flex-direction: column;
                align-items: center;
                gap: 15px;
            }

            .hero {
                padding: 150px 0 100px;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .counter-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-content">
            <div class="logo">
                <i class="fas fa-leaf" style="margin-right: 10px;"></i>
                EcoMomentum
            </div>
            <div class="nav-links">
                <a href="#home">Home</a>
                <a href="#impact">Impact</a>
                <a href="#events">Events</a>
                <a href="#newsletter">Newsletter</a>
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="container">
            <h1>Climate Action Starts Now</h1>
            <p>Join millions of young activists worldwide in the fight against climate change. Together, we can create a sustainable future for our planet.</p>
            <a href="login/login.php" class="cta-button">Get Involved</a>
        </div>
    </section>

    <section class="impact-counter">
        <div class="container">
            <h2>Our Collective Impact</h2>
            <div class="counter-grid">
                <div class="counter-item">
                    <div class="counter-number" id="eventsCounter">0</div>
                    <p>Global Events</p>
                </div>
                <div class="counter-item">
                    <div class="counter-number" id="volunteerCounter">0</div>
                    <p>Active Volunteers</p>
                </div>
                <div class="counter-item">
                    <div class="counter-number" id="carbonCounter">0</div>
                    <p>CO2 Reduced (Tons)</p>
                </div>
                <div class="counter-item">
                    <div class="counter-number" id="countriesCounter">0</div>
                    <p>Countries Reached</p>
                </div>
            </div>
        </div>
    </section>

    <section class="newsletter">
        <div class="container">
            <h2>Stay Updated</h2>
            <p>Join our newsletter for the latest climate action updates</p>
            <form class="newsletter-form">
                <input type="email" placeholder="Enter your email" required>
                <button type="submit">Subscribe</button>
            </form>
        </div>
    </section>

    <section class="social-proof">
        <div class="container">
            <h2>Our Global Partners</h2>
            <div class="partners-grid">
                <img src="https://via.placeholder.com/150x80?text=Partner+1" alt="Partner Logo">
                <img src="https://via.placeholder.com/150x80?text=Partner+2" alt="Partner Logo">
                <img src="https://via.placeholder.com/150x80?text=Partner+3" alt="Partner Logo">
                <img src="https://via.placeholder.com/150x80?text=Partner+4" alt="Partner Logo">
            </div>
        </div>
    </section>

    <footer>
        © 2024 EcoMomentum All rights reserved.
    </footer>

    <script>
        function animateCounters() {
            const counterElements = [
                { element: document.getElementById('eventsCounter'), target: 500 },
                { element: document.getElementById('volunteerCounter'), target: 50000 },
                { element: document.getElementById('carbonCounter'), target: 100000 },
                { element: document.getElementById('countriesCounter'), target: 120 }
            ];

            counterElements.forEach(({element, target}) => {
                let current = 0;
                const increment = target / 100;
                
                const updateCounter = () => {
                    current += increment;
                    if (current < target) {
                        element.textContent = Math.round(current).toLocaleString();
                        requestAnimationFrame(updateCounter);
                    } else {
                        element.textContent = target.toLocaleString();
                    }
                };

                updateCounter();
            });
        }

        document.querySelector('.newsletter-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input').value;
            alert(`Thank you for subscribing with ${email}!`);
            this.reset();
        });

        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };

        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    counterObserver.unobserve(entry.target);
                }
            });
        }, observerOptions);

        counterObserver.observe(document.querySelector('.impact-counter'));
    </script>
</body>
</html>