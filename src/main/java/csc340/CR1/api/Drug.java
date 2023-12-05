package csc340.CR1.api;

import lombok.AllArgsConstructor;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;

import java.time.LocalDate;

@NoArgsConstructor
@Getter
@Setter
public class Drug {
    private String name;
    private String usage;
    private String dosage;
    private String reactions;

    /**
     * All arguments constructor for a Drug object to store api results
     * @param name
     * @param usage
     * @param dosage
     * @param reactions
     */
    public Drug(String name, String usage, String dosage, String reactions) {
        this.name = name;
        this.usage = usage;
        this.dosage = dosage;
        this.reactions = reactions;
    }
}
