document.addEventListener("DOMContentLoaded", () => {
  initMenu();
  initSmoothScroll();
  initActiveNav();
  initReveal();
});

/* =========================
   MENÚ MOBILE
========================= */
function initMenu() {
  const toggle = document.getElementById("menu-toggle");
  const nav = document.getElementById("nav");

  if (!toggle || !nav) return;

  toggle.addEventListener("click", () => {
    nav.classList.toggle("open");
    toggle.classList.toggle("active");
  });

  // cerrar menú al hacer click en enlace
  document.querySelectorAll("#nav a").forEach(link => {
    link.addEventListener("click", () => {
      nav.classList.remove("open");
      toggle.classList.remove("active");
    });
  });
}

/* =========================
   SCROLL SUAVE
========================= */
function initSmoothScroll() {
  const links = document.querySelectorAll('a[href^="#"]');

  links.forEach(link => {
    link.addEventListener("click", function (e) {
      const targetId = this.getAttribute("href");

      if (targetId === "#" || !targetId) return;

      const target = document.querySelector(targetId);
      if (!target) return;

      e.preventDefault();

      const headerOffset = 80;
      const elementPosition = target.getBoundingClientRect().top;
      const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

      window.scrollTo({
        top: offsetPosition,
        behavior: "smooth"
      });
    });
  });
}

/* =========================
   LINK ACTIVO EN SCROLL
========================= */
function initActiveNav() {
  const sections = document.querySelectorAll("section[id]");
  const navLinks = document.querySelectorAll("#nav a");

  if (!sections.length) return;

  window.addEventListener("scroll", () => {
    let current = "";

    sections.forEach(section => {
      const sectionTop = section.offsetTop - 120;
      const sectionHeight = section.offsetHeight;

      if (window.scrollY >= sectionTop && window.scrollY < sectionTop + sectionHeight) {
        current = section.getAttribute("id");
      }
    });

    navLinks.forEach(link => {
      link.classList.remove("active");
      if (link.getAttribute("href") === `#${current}`) {
        link.classList.add("active");
      }
    });
  });
}

/* =========================
   ANIMACIÓN REVEAL
========================= */
function initReveal() {
  const elements = document.querySelectorAll(".reveal");

  if (!elements.length) return;

  const observer = new IntersectionObserver(
    entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add("visible");
          observer.unobserve(entry.target);
        }
      });
    },
    {
      threshold: 0.15
    }
  );

  elements.forEach(el => observer.observe(el));
}

function initFormStatus() {
  const status = new URLSearchParams(window.location.search).get("status");
  const formStatus = document.getElementById("formStatus");

  if (!formStatus) return;

  if (status === "success") {
    formStatus.textContent = "Tu mensaje fue enviado correctamente.";
    formStatus.className = "form-status success";
  } else if (status === "error") {
    formStatus.textContent = "Hubo un problema al enviar el mensaje.";
    formStatus.className = "form-status error";
  } else if (status === "invalid_email") {
    formStatus.textContent = "El correo ingresado no es válido.";
    formStatus.className = "form-status error";
  } else {
    formStatus.textContent = "";
  }

  if (status) {
    window.history.replaceState({}, document.title, window.location.pathname);
  }
}

document.addEventListener("DOMContentLoaded", () => {
  initMenu();
  initSmoothScroll();
  initActiveNav();
  initReveal();
  initFormStatus();
});