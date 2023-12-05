//Toggle button form for the Patient Portal
document.addEventListener("DOMContentLoaded", function () {
    const toggleButton = document.getElementById("toggleButton");
    const content = document.getElementById("content");

    // Initial state: content is hidden
    content.style.display = "none";

    // Toggle the content when the button is clicked
    toggleButton.addEventListener("click", function () {
        if (content.style.display === "none") {
            content.style.display = "block";
            toggleButton.textContent = "Hide"; // Change button text to "Hide"
        } else {
            content.style.display = "none";
            toggleButton.textContent = "View"; // Change button text back to "View"
        }
    });
});


// JS for Appointment Form
document.addEventListener("DOMContentLoaded", function () {
    // Get a reference to the form element
    const appointmentForm = document.getElementById("appointment-form");

    // Add a submit event listener to the form
    appointmentForm.addEventListener("submit", function (event) {
        // Prevent the default form submission behavior
        event.preventDefault();

        // Retrieve form data if needed
        const formData = new FormData(appointmentForm);

        // Send an AJAX request to save-appointment.php to handle form submission
        fetch("save-appointment.php", {
            method: "POST",
            body: formData,
        })
            .then(response => {
                if (response.ok) {
                    // Handle success if needed
                    console.log("Form submitted successfully");
                } else {
                    // Handle the error response, e.g., display an error message
                    console.error("Form submission failed");
                }
            })
            .catch(error => {
                console.error("An error occurred:", error);
            });
    });
});
