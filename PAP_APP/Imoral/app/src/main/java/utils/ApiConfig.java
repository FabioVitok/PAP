package utils;

public class ApiConfig {
    public static final String BASE_URL = "https://barbecue-fox-sanitary.ngrok-free.dev";
    public static final String USER_URL = BASE_URL + "/api/users/";
    public static final String SIZES_URL = BASE_URL + "/api/byproductspai/";
    public static final String HOME_URL = BASE_URL + "/api/home";
    public static final String LOGIN_URL = BASE_URL + "/api/login";
    public static final String SIGNUP_URL = BASE_URL + "/api/signup";
    public static final String POSTS_URL = BASE_URL + "/api/posts";
    public static final String CARRINHO_URL = BASE_URL + "/api/carrinho_produtos/";
    public static final String CARRINHO_PRODUTO_URL = BASE_URL + "/api/carrinho_produtos";



    private ApiConfig() {
        // impede instância
        // Pois não precisamos de criar objetos
    }
}