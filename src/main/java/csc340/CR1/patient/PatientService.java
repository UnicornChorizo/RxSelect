package csc340.CR1.patient;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class PatientService {

    @Autowired
    private PatientRepo repo;

    /**
     * Get all patients in the database
     * @return
     */
    public List<Patient> getAllPatients() {
        return repo.findAll();
    }

    /**
     * Get a single patient object by their ID
     * @param patient_id
     * @return the patient
     */
    public Patient getPatient(long patient_id) {
        return repo.getReferenceById(patient_id);
    }

    /**
     * Delete a single patient by their ID
     * @param patient_id
     */
    public void deletePatient(long patient_id) {
        repo.deleteById(patient_id);
    }

    /**
     * Save a patient entry.
     * @param patient
     */
    void savePatient(Patient patient) {
        repo.save(patient);
    }
}
