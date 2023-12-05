package csc340.CR1.treatment;

import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;
import org.springframework.cglib.core.Local;

import java.time.LocalDate;

@Entity
@Table(name = "treatment")
@NoArgsConstructor
@AllArgsConstructor
@Getter
@Setter
public class Treatment {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private long id;
    private long patient_id;

    private String rx_name;
    private String treatment_notes;
    private LocalDate presc_date;
    private Boolean completed;

    /**
     * Constructor for a treatment given a localDate date object
     * @param patient_id
     * @param rx_name
     * @param treatment_notes
     * @param presc_date
     * @param completed
     */
    public Treatment(long patient_id, String rx_name, String treatment_notes, LocalDate presc_date,
                     Boolean completed) {
        this.patient_id = patient_id;
        this.rx_name = rx_name;
        this.treatment_notes = treatment_notes;
        this.presc_date = presc_date;
        this.completed = completed;
    }

    /**
     * Constructor for a treatment given a string date object
     * @param patient_id
     * @param rx_name
     * @param treatment_notes
     * @param presc_date
     * @param completed
     */
    public Treatment(long patient_id, String rx_name, String treatment_notes, String presc_date,
                     Boolean completed) {
        this.patient_id = patient_id;
        this.rx_name = rx_name;
        this.treatment_notes = treatment_notes;
        this.presc_date = LocalDate.parse(presc_date);
        this.completed = completed;
    }
}
