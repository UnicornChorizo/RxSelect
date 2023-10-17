// Update your JavaScript file (patient-script.js) as follows:

document.addEventListener("DOMContentLoaded", function () {
    // ... (your existing code)

    // Medications Section
    const medicationList = document.getElementById("medication-list");

    if (medicationList) {
        // Simulated medication data (in a real application, you'd fetch this data from a server)
        const medications = [
            {
                id: 1,
                name: "Medication A",
                dosage: "10mg",
                frequency: "Once daily",
                provider: "Dr. Smith",
                instructions: "Take with food",
                sideEffects: "Drowsiness, nausea",
                refillInfo: "Refillable until 12/31/2023"
            },
            {
                id: 2,
                name: "Medication B",
                dosage: "20mg",
                frequency: "Twice daily",
                provider: "Dr. Jones",
                instructions: "Take in the morning and evening",
                sideEffects: "None",
                refillInfo: "Refillable until 11/30/2023"
            }
        ];

        // Function to display medications in the list
        function displayMedications() {
            medicationList.innerHTML = ""; // Clear the existing list

            medications.forEach(function (medication) {
                const listItem = document.createElement("li");
                listItem.innerHTML = `
                    <strong>Medication ID:</strong> ${medication.id}<br>
                    <strong>Name:</strong> ${medication.name}<br>
                    <strong>Dosage:</strong> ${medication.dosage}<br>
                    <strong>Frequency:</strong> ${medication.frequency}<br>
                    <strong>Provider:</strong> ${medication.provider}<br>
                    <strong>Instructions:</strong> ${medication.instructions}<br>
                    <strong>Side Effects:</strong> ${medication.sideEffects}<br>
                    <strong>Refill Information:</strong> ${medication.refillInfo}<br>
                    <hr>
                `;
                medicationList.appendChild(listItem);
            });
        }

        // Initial display of medications
        displayMedications();
    }
});


// Call the displayAllPrescriptions function outside of the event listener
document.addEventListener("DOMContentLoaded", function () {
    // Get the target element where you want to display all prescriptions
    const prescriptionList = document.getElementById("prescription-list");

    // Call the displayAllPrescriptions function with the target element
    displayAllPrescriptions(prescriptionList);
});

// Generate Appointment Time Slots
document.addEventListener("DOMContentLoaded", function () {
    const appointmentTimeSelect = document.getElementById("appointmentTime");

    // Generate time slots from 8 AM to 5 PM, every 15 minutes
    const startTime = new Date();
    startTime.setHours(8, 0, 0); // Start at 8:00 AM
    const endTime = new Date();
    endTime.setHours(17, 0, 0); // End at 5:00 PM
    const timeInterval = 15; // 15 minutes interval

    while (startTime <= endTime) {
        const option = document.createElement("option");
        const timeString = startTime.toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" });
        option.text = timeString;
        option.value = timeString;
        appointmentTimeSelect.appendChild(option);

        // Increment time by 15 minutes
        startTime.setTime(startTime.getTime() + timeInterval * 60000);
    }
});

// JavaScript to handle the card toggling
document.addEventListener("DOMContentLoaded", function () {
    const toggleButtons = document.querySelectorAll(".toggle-button");

    toggleButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            const card = this.parentElement;
            const content = card.querySelector(".content");

            card.classList.toggle("expanded"); // Toggle the "expanded" class

            if (card.classList.contains("expanded")) {
                // Calculate and set the content's max-height to ensure full expansion
                content.style.maxHeight = content.scrollHeight + "px";
            } else {
                // Reset the content's max-height to zero for collapsing
                content.style.maxHeight = "0";
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const billList = document.getElementById("bill-list");

    if (billList) {
        // Simulated bill data (in a real application, you'd fetch this data from a server)
        const bills = [
            {
                id: 1,
                date: "2023-10-01",
                amount: 100.00,
                insuranceCoverage: 80.00,
                paid: 20.00
            },
            {
                id: 2,
                date: "2023-09-15",
                amount: 75.00,
                insuranceCoverage: 60.00,
                paid: 15.00
            }
        ];

        // Function to display bills in the list
        function displayBills() {
            billList.innerHTML = ""; // Clear the existing list

            bills.forEach(function (bill) {
                const listItem = document.createElement("li");
                listItem.innerHTML = `
                    <strong>Bill ID:</strong> ${bill.id}<br>
                    <strong>Date:</strong> ${bill.date}<br>
                    <strong>Total Amount:</strong> $${bill.amount}<br>
                    <strong>Insurance Coverage:</strong> $${bill.insuranceCoverage}<br>
                    <strong>Amount Paid:</strong> $${bill.paid}<br>
                    <hr>
                `;
                billList.appendChild(listItem);
            });
        }

        // Initial display of bills
        displayBills();
    }
});

document.addEventListener("DOMContentLoaded", function () {
    // Get a reference to the form element
    const appointmentForm = document.querySelector("#request-appointment form");

    // Get a reference to the popup and its content
    const confirmationPopup = document.getElementById("confirmation-popup");
    const popupContent = confirmationPopup.querySelector(".popup-content");

    // Add a submit event listener to the form
    appointmentForm.addEventListener("submit", function (event) {
        // Prevent the default form submission behavior
        event.preventDefault();

        // Retrieve form data if needed
        const formData = new FormData(appointmentForm);

        // Display the popup with appointment details
        const appointmentDetails = getAppointmentDetails(formData); // You can define this function to format appointment details
        document.getElementById("appointment-details").textContent = appointmentDetails;

        // Show the popup
        confirmationPopup.style.display = "block";
    });

    // Close the popup when the close button is clicked
    document.getElementById("close-popup").addEventListener("click", function () {
        confirmationPopup.style.display = "none";
    });
});

function getAppointmentDetails(formData) {
    // You can format the appointment details as needed from the form data
    const firstName = formData.get("firstName");
    const lastName = formData.get("lastName");
    const appointmentDate = formData.get("appointment-date");
    const appointmentTime = formData.get("appointmentTime");

    return `Name: ${firstName} ${lastName}, Date: ${appointmentDate}, Time: ${appointmentTime}`;
}

//Request Appointment Reminder
document.querySelector('form').addEventListener('submit', function (e) {
    e.preventDefault(); // Prevent the default form submission

    // Collect form data
    const formData = new FormData(this);

    // Convert form data to JSON
    const jsonData = {};
    formData.forEach((value, key) => {
        jsonData[key] = value;
    });

    // Extract the ClickSend API key
    const clicksendApiKey = document.getElementById('clicksend-api-key').value;

    // Make a POST request to the ClickSend API
    fetch('https://rest.clicksend.com/v3/sms/send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer 1DC94838-491E-01D5-4984-1AE754E3D763', // Replace with your actual API key
        },
        body: JSON.stringify({
            messages: [{
                source: 'sdk',
                body: `Appointment Request: ${jsonData.firstName} ${jsonData.lastName}, Email: ${jsonData.email}, Phone: ${jsonData.phone}, Date: ${jsonData['appointment-date']}, Time: ${jsonData.appointmentTime}`,
                from: 'Your Sender ID',
                to: 'Recipient Phone Number',
            }],
        }),
    })
        .then(response => response.json())
        .then(data => {
            // Handle the response from ClickSend here
            console.log(data);
            // Display a confirmation message to the user
            showConfirmation();
        })
        .catch(error => {
            // Handle errors here
            console.error(error);
        });
});

function showConfirmation() {
    document.addEventListener("DOMContentLoaded", function () {
        const showConfirmationButton = document.getElementById("show-confirmation");
        const confirmationPopup = document.getElementById("confirmation-popup");
        const closePopupButton = document.getElementById("close-popup");

        showConfirmationButton.addEventListener("click", function () {
            // Display the confirmation popup
            confirmationPopup.style.display = "block";

            // You can update the appointment details here before displaying them
            const appointmentDetails = "Your appointment details go here";
            document.getElementById("appointment-details").textContent = appointmentDetails;
        });

        closePopupButton.addEventListener("click", function () {
            // Close the confirmation popup
            confirmationPopup.style.display = "none";
        });
    });
}
