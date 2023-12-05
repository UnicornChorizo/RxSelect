package csc340.CR1.patient;

import csc340.CR1.patient.PatientRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class PatientDService {

    @Autowired
    private PatientRepository patientRepository;

    public List<PatientD> getAllPatients() {
        return patientRepository.findAll();
    }

    public Optional<PatientD> getPatientById(Long id) {
        return patientRepository.findById(id);
    }

    public PatientD savePatient(PatientD patient) {
        return patientRepository.save(patient);
    }

    public void deletePatient(Long id) {
        patientRepository.deleteById(id);
    }
}
