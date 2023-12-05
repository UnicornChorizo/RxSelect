package csc340.CR1.bill;

import csc340.CR1.patient.PatientD;
import jakarta.persistence.*;
import java.math.BigDecimal;

@Entity
@Table(name = "bills")
public class Bill {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long billId;

    @ManyToOne
    @JoinColumn(name = "patient_id", nullable = false)
    private PatientD patient;

    private BigDecimal amount;
    private String reasonForVisit;
    private boolean isPaid;


    public Bill(Long billId, PatientD patient, BigDecimal amount, String reasonForVisit, boolean isPaid) {
        this.billId = billId;
        this.patient = patient;
        this.amount = amount;
        this.reasonForVisit = reasonForVisit;
        this.isPaid = isPaid;
    }

    public Bill() {

    }

    public Long getBillId() {
        return billId;
    }

    public void setBillId(Long billId) {
        this.billId = billId;
    }

    public PatientD getPatient() {
        return patient;
    }

    public void setPatient(PatientD patient) {
        this.patient = patient;
    }

    public BigDecimal getAmount() {
        return amount;
    }

    public void setAmount(BigDecimal amount) {
        this.amount = amount;
    }

    public String getReasonForVisit() {
        return reasonForVisit;
    }

    public void setReasonForVisit(String reasonForVisit) {
        this.reasonForVisit = reasonForVisit;
    }

    public boolean isPaid() {
        return isPaid;
    }

    public void setPaid(boolean paid) {
        isPaid = paid;
    }
}
