package csc340.CR1.common;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

@Service
public class UserService {
    private final UserRepository userRepository;

    @Autowired
    public UserService(UserRepository userRepository) {
        this.userRepository = userRepository;
    }

    public boolean authenticate(String email, String password) {
        // Find the user by email
        User user = userRepository.findByEmail(email);

        if (user != null && user.getPassword().equals(password)) {
            // Passwords match, user is authenticated
            return true;
        } else {
            // Invalid credentials
            return false;
        }
    }
}
