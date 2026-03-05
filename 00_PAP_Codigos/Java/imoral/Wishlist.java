import java.util.HashMap;
public class Wishlist
{
    private int id;
    private Utilizador user;
    HashMap<String, Produto> produtos;
    public Wishlist(int id, Utilizador user){
        this.id = id;
        this.user = user;
        this.produtos = new HashMap<>();
    }
    
    public Utilizador getUser()
    {
        return this.user;
    }
    
    
    public HashMap getProdutos()
    {
        return this.produtos;
    } 
    
   
}
