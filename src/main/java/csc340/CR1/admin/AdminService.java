package csc340.CR1.admin;

import csc340.CR1.common.User;
import csc340.CR1.common.UserRepository;
import csc340.CR1.patient.PatientD;
import csc340.CR1.patient.PatientRepository;
import jakarta.transaction.Transactional;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import java.util.List;
import java.util.Optional;

@Service
public class AdminService {
    private final PatientRepository patientRepository;
    private final UserRepository userRepository;

    @Autowired
    public AdminService(PatientRepository patientRepository, UserRepository userRepository) {
        this.patientRepository = patientRepository;
        this.userRepository = userRepository;
    }

    @Transactional
    public PatientD addPatient(PatientD patient) {
        // If the user is new (no ID), save the user first
        if (patient.getUser().getUserId() == null) {
            User savedUser = userRepository.save(patient.getUser());
            patient.setUser(savedUser);
        }
        // Now save the patient
        return patientRepository.save(patient);
    }
    public List<PatientD> getAllPatients() {
        return patientRepository.findAll();
    }

    @Transactional
    public PatientD updatePatient(Long patientId, PatientD patientDetails) {
        PatientD patient = patientRepository.findById(patientId)
                .orElseThrow(() -> new RuntimeException("Patient not found"));

        User user = patient.getUser();
        user.setFirstName(patientDetails.getUser().getFirstName());
        user.setLastName(patientDetails.getUser().getLastName());
        user.setEmail(patientDetails.getUser().getEmail());

        patient.setSex(patientDetails.getSex());
        patient.setDob(patientDetails.getDob());

        return patientRepository.save(patient);
    }
    public void deletePatient(Long patientId) {
        patientRepository.deleteById(patientId);
    }


    public Optional<PatientD> findPatientById(Long id) {
        return patientRepository.findById(id);
    }

}
