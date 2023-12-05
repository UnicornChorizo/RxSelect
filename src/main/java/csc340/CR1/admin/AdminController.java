package csc340.CR1.admin;

import csc340.CR1.bill.Bill;
import csc340.CR1.bill.BillService;
import csc340.CR1.appointment.Appointment;
import csc340.CR1.appointment.AppointmentService;
import csc340.CR1.patient.PatientD;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.format.annotation.DateTimeFormat;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.servlet.mvc.support.RedirectAttributes;

import java.util.HashMap;
import java.util.List;
import java.time.LocalTime;
import java.time.LocalDate;
import java.util.Map;

@Controller
@RequestMapping("/admin")
public class AdminController {
    private final AdminService adminService;

    @Autowired
    public AdminController(AdminService adminService, AppointmentService appointmentService, BillService billService) {
        this.adminService = adminService;
        this.appointmentService = appointmentService;
        this.billService = billService;
    }

    @GetMapping("/dashboard")
    public String getAllPatients(Model model) {
        List<PatientD> patients = adminService.getAllPatients();
        model.addAttribute("patients", patients);
        if (!model.containsAttribute("patient")) {
            model.addAttribute("patient", new PatientD());
        }
        return "admin";
    }


    @GetMapping("/patients/{id}")
    public ResponseEntity<PatientD> getPatientById(@PathVariable Long id) {
        return adminService.findPatientById(id)
                .map(ResponseEntity::ok)
                .orElse(ResponseEntity.notFound().build());
    }

    @PostMapping("/dashboard")
    public String addPatient(@ModelAttribute PatientD patient, RedirectAttributes redirectAttributes) {
        adminService.addPatient(patient);
        redirectAttributes.addFlashAttribute("successMessage", "Patient added successfully");
        return "redirect:/admin/dashboard";
    }


    @PutMapping("/patients/{id}")
    public PatientD updatePatient(@PathVariable Long id, @RequestBody PatientD patient) {
        return adminService.updatePatient(id, patient);
    }

    @DeleteMapping("/patients/{id}")
    public String deletePatient(@PathVariable Long id, RedirectAttributes redirectAttributes) {
        adminService.deletePatient(id);
        redirectAttributes.addFlashAttribute("successMessage", "Patient deleted successfully");
        return "redirect:/admin/dashboard";
    }


    private final AppointmentService appointmentService;

    @GetMapping("/schedule")
    public String viewAppointments(Model model) {
        List<Appointment> appointments = appointmentService.getAllAppointments();
        List<PatientD> patients = adminService.getAllPatients(); // Fetch all patients
        model.addAttribute("appointments", appointments);
        model.addAttribute("patients", patients); // Add patients to the model
        return "schedule"; // Return the appointment view page
    }

    @PostMapping("/schedule")
    public String scheduleAppointment(@RequestParam("patientId") Long patientId,
                                      @RequestParam("date") @DateTimeFormat(iso = DateTimeFormat.ISO.DATE) LocalDate date,
                                      @RequestParam("time") @DateTimeFormat(iso = DateTimeFormat.ISO.TIME) LocalTime time,
                                      RedirectAttributes redirectAttributes) {

        // Fetch the patient based on patientId
        PatientD patient = adminService.findPatientById(patientId)
                .orElseThrow(() -> new IllegalArgumentException("Invalid patient ID"));

        // Create a new Appointment object
        Appointment appointment = new Appointment();
        appointment.setPatient(patient); // Set the fetched patient
        appointment.setDate(date); // Set the date
        appointment.setTime(time); // Set the time

        // Save the appointment
        appointmentService.createAppointment(appointment);

        redirectAttributes.addFlashAttribute("successMessage", "Appointment scheduled successfully");
        return "redirect:/admin/schedule";
    }

    @DeleteMapping("/appointments/{id}")
    public String deleteAppointment(@PathVariable Long id, RedirectAttributes redirectAttributes) {
        appointmentService.deleteAppointment(id);
        redirectAttributes.addFlashAttribute("successMessage", "Appointment canceled successfully");
        return "redirect:/admin/schedule";
    }


    private final BillService billService;

    @GetMapping("/bill")
    public String viewBillingPage(Model model) {
        List<PatientD> patients = adminService.getAllPatients();
        // Fetch bills for each patient and add them to the model
        Map<Long, List<Bill>> patientBills = new HashMap<>();
        for (PatientD patient : patients) {
            List<Bill> bills = billService.getBillsByPatientId(patient.getPatientId());
            patientBills.put(patient.getPatientId(), bills);
        }
        model.addAttribute("patients", patients);
        model.addAttribute("patientBills", patientBills);
        return "bill";
    }


    @PostMapping("/bill")
    public String addBill(@ModelAttribute Bill bill, @RequestParam("patientId") Long patientId, RedirectAttributes redirectAttributes) {
        PatientD patient = adminService.findPatientById(patientId)
                .orElseThrow(() -> new IllegalArgumentException("Invalid patient ID"));
        bill.setPatient(patient);
        billService.addBill(bill);
        redirectAttributes.addFlashAttribute("successMessage", "Bill added successfully");
        return "redirect:/admin/bill";
    }



}
