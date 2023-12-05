package csc340.CR1.appointment;

import csc340.CR1.patient.PatientD;
import jakarta.persistence.*;

import java.time.LocalDate;
import java.time.LocalTime;

@Entity
@Table(name = "appointments")
public class Appointment {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "appointment_id")
    private Long appointmentId;

    @Column(name = "appointment_date")
    private LocalDate date;

    @Column(name = "appointment_time")
    private LocalTime time;

    @ManyToOne
    @JoinColumn(name = "patient_id")
    private PatientD patient;

    public Appointment(Long id, LocalDate date, LocalTime time, PatientD patient) {
        this.appointmentId = id;
        this.date = date;
        this.time = time;
        this.patient = patient;
    }

    public Appointment() {

    }


    public Long getId() {
        return appointmentId;
    }

    public void setId(Long id) {
        this.appointmentId = id;
    }

    public LocalDate getDate() {
        return date;
    }

    public void setDate(LocalDate date) {
        this.date = date;
    }

    public LocalTime getTime() {
        return time;
    }

    public void setTime(LocalTime time) {
        this.time = time;
    }

    public PatientD getPatient() {
        return patient;
    }

    public void setPatient(PatientD patient) {
        this.patient = patient;
    }
}
