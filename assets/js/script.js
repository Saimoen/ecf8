// script.js
document.addEventListener("keydown", function (event) {
    let direction = null;
    console.log(event);
    switch (event.key) {
        case "ArrowUp" || "z":
            direction = 0;
            break;
        case "ArrowRight" || "KeyD":
            direction = 1;
            break;
        case "ArrowDown" || "KeyS":
            direction = 2;
            break;
        case "ArrowLeft" || "KeyQ":
            direction = 3;
            break;
    }

    if (direction !== null) {
        // Make an AJAX call to your controller using the direction
        window.location.href =
            "/findthetreaser/controllers/controller.php?direction=" + direction;
    }
});
