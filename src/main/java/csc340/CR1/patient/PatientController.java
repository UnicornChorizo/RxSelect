package csc340.CR1.patient;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.ui.Model;

@Controller
@RequestMapping("/patient")
public class PatientController {

    @Autowired
    PatientService patientService;

    /**
     * Display the list of all patients in the database with links to their history pages
     * @param model
     * @return
     */
    @GetMapping("/all")
    public String getAllPatients(Model model) {
        model.addAttribute("patientList", patientService.getAllPatients());
        return "hcw/patient-list";
    }

    /**
     * View all treatments for a given patient, with none selected
     * @param patient_id
     * @param model
     * @return
     */
    @GetMapping("/id={patient_id}")
    public String getPatient(@PathVariable long patient_id, Model model) {
        model.addAttribute("patient", patientService.getPatient(patient_id));
        return "hcw/patient-history";
    }
}
