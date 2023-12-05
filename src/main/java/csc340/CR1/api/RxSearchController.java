package csc340.CR1.api;

import csc340.CR1.treatment.Treatment;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.*;
import org.springframework.ui.Model;

@Controller
@RequestMapping("/rxsearch")
public class RxSearchController {
    @Autowired
    RxSearchService searchService;

    /**
     * Shows the search page with an empty table
     * @return search page
     */
    @GetMapping("/search")
    public String blank(Model model) {
        Search blank_search = new Search(" ");
        model.addAttribute("search", blank_search);
        return "hcw/rx-search";
    }

    /**
     * Shows the search page, filling the table with the API results (MAX 2)
     * @param search
     * @param model
     * @return
     */
    @PostMapping("/results")
    public String getResults(Search search, Model model) {
        model.addAttribute("rxList", RxSearchService.getResults(search.getTerm()));
        return "hcw/rx-search";
    }
}
