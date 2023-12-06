# RxSelect
### Project Execution Instructions Below
# Team Members

Jesse Carter (Healthcare Worker),
Kevin Ornelas Ceron (Admin),
Romario Barahona (Patient)


# Description

Help healthcare workers coordinate treatment plans for patients and allow patients to easily check presciptions and treatment history.

RxSelect is a powerful and user-friendly medication management app designed to simplify your healthcare routine. With RxSelct, you can effortlessly manage your prescriptions and stay on top of your health journey.

Key Features:

- Symptom-Based RX Lookup: Healthcare workers can easily search for medications based on symptoms and get accurate, up-to-date information about FDA approved drugs from the openFDA API. They can also search by drug name to learn more about a specific drug before prescribing it.
- Treatment History: Keep a detailed record of each patient's health history, easily stored, searched, and edited as necessary.
- Patient Portal: Patients can view their billing information and request new appointments, which can then be approved and managed by the administrators. 

# Use Case Diagram

![Screenshot of Use Case Diagram](RxSelect_Use-Case.png)

# Note For SQL Imports
There must be two databases created in myphpadmin, "code-review" and "patientdb", containing the tables and dummy data found in "SQL Imports for Grading" / code-review.sql and patientdb.sql

# Note for Execution 
To execute the program, the following requirements must be met: 
- The project files must be located within xampp/htdocs/ (default installation location is C:/xampp/htdocs/) 
- In XAMPP Control Panel:
  * Under Apache -> Config -> httpd.conf, change "Listen 80" to "Listen 3000"
  * Start Apache
  * Start MySQL
- In IntelliJ, Run the application from src/main/java/csc340/CR1/CR1Application.java
- Once running, the starting point for the program will be: http://localhost:3000/RxSelect/
- Login information: All accounts use the password "test"
  * Doctor Login: jsmith@doctors.rxselect.com
  * Admin Login: jdoe@admin.rxselect.com
  * Patient Login(s): romario.barahona@gmail.com, mlittle82@email.com, shopkins01@email.com, jsharp72@email.com, jroberts95@email.com