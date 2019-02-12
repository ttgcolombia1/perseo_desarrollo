// No Back
window.onbeforeunload = function() {
    console.log("bye");
    window.history.forward();
};