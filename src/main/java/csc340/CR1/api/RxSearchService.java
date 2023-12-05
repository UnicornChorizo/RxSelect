package csc340.CR1.api;

import com.fasterxml.jackson.core.JsonProcessingException;
import com.fasterxml.jackson.databind.JsonNode;
import com.fasterxml.jackson.databind.ObjectMapper;
import org.springframework.stereotype.Service;
import org.springframework.web.client.RestTemplate;

import java.util.ArrayList;
import java.util.List;

@Service
public class RxSearchService {

    /**
     * Helper function to clean up api data
     * @param name dirty RX name string
     * @return cleaned name string
     */
    private static String fixName(String name) {
        // Get only the first entry in the list
        name = (name + " ").split(" ")[0];
        // Remove the brackets and open quotes from the start of the string
        name = name.substring(name.lastIndexOf("\"") + 1);
        // Normalize case to uppercase
        name = name.toUpperCase();
        return name;
    }

    /**
     * Function to make a call to the openfda api and return the top 2 results of the search term
     * Note: Needs better error checking to check for null results / no results found
     * @param term
     * @return
     */
    public static List<Drug> getResults(String term) {
        try {
            String url = "https://api.fda.gov/drug/label.json?search=";
            url = url.concat("\"" + term + "\"");
            url = url.concat("&limit=2");
            RestTemplate restTemplate = new RestTemplate();
            ObjectMapper mapper = new ObjectMapper();

            String jSonPrice = restTemplate.getForObject(url, String.class);
            JsonNode root = mapper.readTree(jSonPrice);

            // Get Rx Names
            String name1 = root.get("results").get(0).get("spl_product_data_elements").toString();
            String name2 = root.get("results").get(1).get("spl_product_data_elements").toString();
            //String name3 = root.get("results").get(2).get("spl_product_data_elements").toString();
            // Extract simple name from the list returned
            name1 = fixName(name1);
            name2 = fixName(name2);

            // Get Usage, Dosage, and Reactions info
            String usage1 = root.get("results").get(0).get("indications_and_usage").toString();
            String dosage1 = root.get("results").get(0).get("dosage_and_administration").toString();
            String reactions1 = root.get("results").get(0).get("adverse_reactions").toString();
            String usage2 = root.get("results").get(1).get("indications_and_usage").toString();
            String dosage2 = root.get("results").get(1).get("dosage_and_administration").toString();
            String reactions2 = root.get("results").get(1).get("adverse_reactions").toString();

            // Create Drug objects
            Drug drug1 = new Drug(name1, usage1, dosage1, reactions1);
            Drug drug2 = new Drug(name2, usage2, dosage2, reactions2);

            // Create Drug List
            List<Drug> RxList = new ArrayList<>();
            RxList.add(drug1);
            RxList.add(drug2);
            return RxList;

        } catch (JsonProcessingException ex) {
            System.out.println("Json Processing Exception");
        }
        return null;
    }


}
