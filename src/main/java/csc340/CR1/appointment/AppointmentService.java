package csc340.CR1.appointment;

import csc340.CR1.patient.PatientD;
import csc340.CR1.patient.PatientRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class AppointmentService {

    private final AppointmentRepository appointmentRepository;
    private final PatientRepository patientRepository;

    @Autowired
    public AppointmentService(AppointmentRepository appointmentRepository, PatientRepository patientRepository) {
        this.appointmentRepository = appointmentRepository;
        this.patientRepository = patientRepository;
    }

    public List<Appointment> getAllAppointments() {
        return appointmentRepository.findAll();
    }

    public Appointment createAppointment(Appointment appointment) {
        // Find the patient by ID
        PatientD patient = patientRepository.findById(appointment.getPatient().getPatientId())
                .orElseThrow(() -> new RuntimeException("Patient not found"));

        // Set the patient to the appointment
        appointment.setPatient(patient);

        // Save the appointment
        return appointmentRepository.save(appointment);
    }

    public void deleteAppointment(Long id) {
        appointmentRepository.deleteById(id);
    }


}
