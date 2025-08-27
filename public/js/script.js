 window.addEventListener("load", () => {
      const preloader = document.getElementById("preloader");
      const preImg = document.getElementById("preloader-img");
      const content = document.getElementById("content");

      // Tambah animasi keluar
      setTimeout(() => {
        preImg.style.animation = "stretchOut 0.6s ease forwards";
        preloader.style.transition = "opacity 0.6s ease";
        preloader.style.opacity = "0";

        setTimeout(() => {
          preloader.style.display = "none";
          content.classList.remove("hidden");
        }, 600);
      }, 1500); 
    });