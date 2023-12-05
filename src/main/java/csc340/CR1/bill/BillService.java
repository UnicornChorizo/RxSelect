package csc340.CR1.bill;

import java.util.List;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

@Service
public class BillService {
    private final BillRepository billRepository;

    @Autowired
    public BillService(BillRepository billRepository) {
        this.billRepository = billRepository;
    }

    public Bill addBill(Bill bill) {
        return billRepository.save(bill);
    }


    public List<Bill> getBillsByPatientId(Long patientId) {
        return billRepository.findByPatientPatientId(patientId);
    }
}
