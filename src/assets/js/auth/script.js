document.addEventListener("DOMContentLoaded", () => {
    // CIERRE DE SESIÓN
    const logoutBtns = document.querySelectorAll(".logout-btn");

    logoutBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            $.ajax({
                url: "/src/config/ajax_requests.php",
                method: "POST",
                data: { action: 'logout' },
                success: () => {
                    window.location.href = "/pages/auth/login.php";
                },
                error: (error) => {
                    console.error("Error al cerrar sesión:", error);
                }
            });
        });
    });
});