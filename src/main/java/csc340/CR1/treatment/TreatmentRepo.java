package csc340.CR1.treatment;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import java.util.List;

public interface TreatmentRepo extends JpaRepository<Treatment, Long> {

    /**
     * Query to get the list of all treatments for a given patient
     * @param patient_id
     * @return
     */
    @Query("SELECT t FROM Treatment t WHERE t.patient_id = ?1")
    public List<Treatment> getTreatmentsByPatientId(long patient_id);

    /**
     * Query to get the most recently prescribed treatment from a patient's list of all treatments
     * @param patient_id
     * @return
     */
    @Query("SELECT t FROM Treatment t WHERE t.patient_id = ?1 AND t.presc_date = (SELECT MAX(t.presc_date) FROM Treatment t WHERE t.patient_id = ?1)")
    public Treatment getCurrentTreatment(long patient_id);
}
