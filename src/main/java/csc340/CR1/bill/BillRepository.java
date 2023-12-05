package csc340.CR1.bill;

// In BillRepository.java
import org.springframework.data.jpa.repository.JpaRepository;

import java.util.List;

public interface BillRepository extends JpaRepository<Bill, Long> {
    List<Bill> findByPatientPatientId(Long patientId); // Method to find bills by patient ID
}
