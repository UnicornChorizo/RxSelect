package csc340.CR1.patient;

import org.springframework.data.jpa.repository.JpaRepository;

public interface PatientRepo  extends JpaRepository<Patient, Long> {
    /**
     * Default repository implementation for JPA
     */
}
