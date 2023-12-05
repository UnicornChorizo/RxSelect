package csc340.CR1.patient;

import jakarta.persistence.*;
import lombok.AllArgsConstructor;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;

import java.time.LocalDate;

/**
 *
 * @author Jesse Carter
 */
@Entity
@Table(name = "patient")
@NoArgsConstructor
@AllArgsConstructor
@Getter
@Setter
public class Patient {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private long id;

    private String username;
    private String first_name;
    private String last_name;
    private LocalDate date_of_birth;

    /**
     * Patient constructor given LocalDate date of birth
     * @param username
     * @param first_name
     * @param last_name
     * @param date_of_birth
     */
    public Patient(String username, String first_name, String last_name, LocalDate date_of_birth) {
        this.username = username;
        this.first_name = first_name;
        this.last_name = last_name;
        this.date_of_birth = date_of_birth;
    }

    /**
     * Patient constructor given String date of birth
     * @param username
     * @param first_name
     * @param last_name
     * @param date_of_birth
     */
    public Patient(String username, String first_name, String last_name, String date_of_birth) {
        this.username = username;
        this.first_name = first_name;
        this.last_name = last_name;
        this.date_of_birth = LocalDate.parse( date_of_birth );
    }

}
