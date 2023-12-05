package csc340.CR1.treatment;

import csc340.CR1.patient.Patient;
import csc340.CR1.patient.PatientService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;

import java.util.ArrayList;
import java.util.List;

@Controller
@RequestMapping("/history")
public class TreatmentController {

    @Autowired
    TreatmentService treatmentService;
    @Autowired
    PatientService patientService;

    /**
     * Show list of all treatments for a given patient, with most recent treatment displayed as current
     * @param patient_id
     * @param model
     * @return
     */
    @GetMapping("/patient_id={patient_id}")
    public String getPatient(@PathVariable long patient_id, Model model) {
        if (treatmentService.getTreatmentByPatientId(patient_id).isEmpty()) {
            model.addAttribute("patient", patientService.getPatient(patient_id));
            List<Treatment> empty_list = new ArrayList<>();
            model.addAttribute("treatmentList", empty_list);
            Treatment empty_treatment = new Treatment();
            model.addAttribute("currentTreatment", empty_treatment);
        } else {
            model.addAttribute("patient", patientService.getPatient(patient_id));
            model.addAttribute("treatmentList", treatmentService.getTreatmentByPatientId(patient_id));
            model.addAttribute("currentTreatment", treatmentService.getCurrentTreatment(patient_id));
        }
        return "hcw/patient-history";
    }

    /**
     * Show list of all treatments for a given patient with the selected treatment as current
     * @param patient_id
     * @param treatment_id
     * @param model
     * @return
     */
    @GetMapping("/patient_id={patient_id}/treatment_id={treatment_id}")
    public String getTreatment(@PathVariable long patient_id, @PathVariable long treatment_id, Model model) {
        model.addAttribute("patient", patientService.getPatient(patient_id));
        model.addAttribute("treatmentList", treatmentService.getTreatmentByPatientId(patient_id));
        model.addAttribute("currentTreatment", treatmentService.getTreatment(treatment_id));
        return "hcw/patient-history";
    }

    /**
     * Update an existing treatment's information in the database
     * @param treatment
     * @return
     */
    @PostMapping("/update")
    public String updateCurrentTreatment(Treatment treatment) {
        treatmentService.saveTreatment(treatment);
        return "redirect:/history/patient_id=" + treatment.getPatient_id();
    }

    /**
     * Delete the currently selected treatment from the database
     * @param treatment
     * @return
     */
    @RequestMapping("/delete")
    public String deleteCurrentTreatment(Treatment treatment) {
        treatmentService.deleteTreatment(treatment.getId());
        return "redirect:/history/patient_id=" + treatment.getPatient_id();
    }

    /**
     * Add the information from the "current treatment" fields as a new treatment in the database
     * @param currentTreatment
     * @return
     */
    @RequestMapping("/add")
    public String add(Treatment currentTreatment) {
        long patient_id = currentTreatment.getPatient_id();
        String rx_name = currentTreatment.getRx_name();
        String treatment_notes = currentTreatment.getTreatment_notes();
        String presc_date = currentTreatment.getPresc_date().toString();
        Boolean completed = currentTreatment.getCompleted();
        treatmentService.saveTreatmentFromParams(patient_id, rx_name, treatment_notes, presc_date, completed);
        return "redirect:/history/patient_id=" + currentTreatment.getPatient_id();
    }
}
