package csc340.CR1.treatment;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;

@Service
public class TreatmentService {

    @Autowired
    private TreatmentRepo repo;

    /**
     * Get all treatments in the database for every patient
     * @return
     */
    public List<Treatment> getAllTreatments() {
        return repo.findAll();
    }

    /**
     * Get a single treatment object by their ID
     * @param treatment_id
     * @return the treatment
     */
    public Treatment getTreatment(long treatment_id) {
        return repo.getReferenceById(treatment_id);
    }

    /**
     * Delete a single treatment by its ID
     * @param treatment_id
     */
    public void deleteTreatment(long treatment_id) {
        repo.deleteById(treatment_id);
    }

    /**
     * Save a treatment entry from treatment object.
     * @param treatment
     */
    void saveTreatment(Treatment treatment) {
        repo.save(treatment);
    }

    /**
     * Save a treatment entry given its parameters
     * @param patient_id
     * @param rx_name
     * @param treatment_notes
     * @param presc_date
     * @param completed
     */
    void saveTreatmentFromParams(long patient_id, String rx_name, String treatment_notes, String presc_date,Boolean completed) {
        Treatment newTreatment = new Treatment(patient_id, rx_name, treatment_notes, presc_date, completed);
        repo.save(newTreatment);
    }

    /**
     * Get all treatments for a given patient
     * @param patient_id
     * @return
     */
    public List<Treatment> getTreatmentByPatientId(long patient_id) { return repo.getTreatmentsByPatientId(patient_id); }

    /**
     * Get the treatment for a given patient with the most recent prescription date
     * @param patient_id
     * @return
     */
    public Treatment getCurrentTreatment(long patient_id) { return repo.getCurrentTreatment(patient_id); }
}
