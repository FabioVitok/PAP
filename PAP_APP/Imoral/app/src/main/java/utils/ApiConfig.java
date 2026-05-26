package utils;

public class ApiConfig {
    public static final String BASE_URL = "https://barbecue-fox-sanitary.ngrok-free.dev";
    public static final String HELP_URL = BASE_URL + "/api/signup";
    public static final String USER_URL = BASE_URL + "/api/users/";
    public static final String HOME_URL = BASE_URL + "/api/home";
    public static final String LOGIN_URL = BASE_URL + "/api/login";

    private ApiConfig() {
        // impede instância
        // Pois não precisamos de criar objetos
    }
}