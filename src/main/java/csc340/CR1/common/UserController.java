package csc340.CR1.common;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RestController;

import java.util.HashMap;
import java.util.Map;

@RestController
public class UserController {

    private UserService userService; // Declare and inject UserService here

    @Autowired
    public UserController(UserService userService) {
        this.userService = userService;
    }

//    @PostMapping("/login")
//    public ResponseEntity<?> login(@RequestBody LoginRequest loginRequest) {
//        // Perform user authentication logic (e.g., check credentials against a database)
//        boolean isAuthenticated = userService.authenticate(loginRequest.getEmail(), loginRequest.getPassword());
//
//        if (isAuthenticated) {
//            Map<String, String> response = new HashMap<>();
//            response.put("message", "Login successful");
//            return ResponseEntity.ok(response);
//        } else {
//            Map<String, String> response = new HashMap<>();
//            response.put("message", "Login failed");
//            return ResponseEntity.status(HttpStatus.UNAUTHORIZED).body(response);
//        }
//    }
}
