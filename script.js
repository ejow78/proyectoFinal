document.addEventListener("DOMContentLoaded", () => {
  // Mobile menu toggle
  const mobileToggle = document.getElementById("mobileToggle")
  const navMenu = document.getElementById("navMenu")

  if (mobileToggle && navMenu) {
    mobileToggle.addEventListener("click", () => {
      navMenu.classList.toggle("active")
      mobileToggle.classList.toggle("active")
    })
  }

  // Close mobile menu when clicking on links
  const navLinks = document.querySelectorAll(".nav-link")
  navLinks.forEach((link) => {
    link.addEventListener("click", () => {
      if (window.innerWidth <= 768) {
        navMenu.classList.remove("active")
        mobileToggle.classList.remove("active")
      }
    })
  })

  // Navbar scroll effect
  const navbar = document.getElementById("navbar")

  window.addEventListener("scroll", () => {
    if (window.scrollY > 100) {
      navbar.classList.add("scrolled")
    } else {
      navbar.classList.remove("scrolled")
    }
  })

  // Carousel functionality
  const carousel = document.getElementById("carousel")
  if (carousel) {
    const slides = carousel.querySelectorAll(".carousel-slide")
    const prevBtn = document.getElementById("prevBtn")
    const nextBtn = document.getElementById("nextBtn")
    let currentSlide = 0

    function showSlide(index) {
      slides.forEach((slide, i) => {
        slide.classList.toggle("active", i === index)
      })
    }

    function nextSlide() {
      currentSlide = (currentSlide + 1) % slides.length
      showSlide(currentSlide)
    }

    function prevSlide() {
      currentSlide = (currentSlide - 1 + slides.length) % slides.length
      showSlide(currentSlide)
    }

    if (nextBtn) nextBtn.addEventListener("click", nextSlide)
    if (prevBtn) prevBtn.addEventListener("click", prevSlide)

    // Auto-advance carousel
    setInterval(nextSlide, 4000)
  }

  // Contact form handling
  const contactForm = document.getElementById("contactForm")
  if (contactForm) {
    contactForm.addEventListener("submit", function (e) {
      e.preventDefault()

      const submitBtn = this.querySelector(".btn-submit")
      const originalText = submitBtn.innerHTML

      // Show loading state
      submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...'
      submitBtn.disabled = true

      // Simulate form submission
      setTimeout(() => {
        showNotification("¡Mensaje enviado exitosamente! Te contactaremos pronto.", "success")
        contactForm.reset()
        submitBtn.innerHTML = originalText
        submitBtn.disabled = false
      }, 2000)
    })
  }

  // Notification system
  function showNotification(message, type = "info") {
    const notification = document.createElement("div")
    notification.className = `notification notification-${type}`
    notification.innerHTML = `
            <div class="notification-content">
                <i class="fas ${type === "success" ? "fa-check-circle" : "fa-info-circle"}"></i>
                <span>${message}</span>
                <button class="notification-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `

    // Styles
    Object.assign(notification.style, {
      position: "fixed",
      top: "20px",
      right: "20px",
      background: type === "success" ? "#10b981" : "#3b82f6",
      color: "white",
      padding: "1rem 1.5rem",
      borderRadius: "8px",
      boxShadow: "0 10px 15px -3px rgb(0 0 0 / 0.1)",
      zIndex: "10000",
      transform: "translateX(100%)",
      transition: "transform 0.3s ease",
      maxWidth: "400px",
    })

    const content = notification.querySelector(".notification-content")
    Object.assign(content.style, {
      display: "flex",
      alignItems: "center",
      gap: "0.75rem",
    })

    const closeBtn = notification.querySelector(".notification-close")
    Object.assign(closeBtn.style, {
      background: "none",
      border: "none",
      color: "white",
      cursor: "pointer",
      padding: "0",
      marginLeft: "auto",
    })

    document.body.appendChild(notification)

    // Show notification
    setTimeout(() => {
      notification.style.transform = "translateX(0)"
    }, 100)

    // Auto hide
    setTimeout(() => {
      notification.style.transform = "translateX(100%)"
      setTimeout(() => notification.remove(), 300)
    }, 5000)

    // Close button
    closeBtn.addEventListener("click", () => {
      notification.style.transform = "translateX(100%)"
      setTimeout(() => notification.remove(), 300)
    })
  }

  // Smooth scrolling for anchor links
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault()
      const target = document.querySelector(this.getAttribute("href"))
      if (target) {
        const offsetTop = target.offsetTop - 80 // Account for navbar
        window.scrollTo({
          top: offsetTop,
          behavior: "smooth",
        })
      }
    })
  })

  // Animation on scroll
  const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px",
  }

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = "1"
        entry.target.style.transform = "translateY(0)"
      }
    })
  }, observerOptions)

  // Observe elements for animation
  const animatedElements = document.querySelectorAll(".program-card, .stat-item")
  animatedElements.forEach((el) => {
    el.style.opacity = "0"
    el.style.transform = "translateY(30px)"
    el.style.transition = "opacity 0.6s ease-out, transform 0.6s ease-out"
    observer.observe(el)
  })
})
