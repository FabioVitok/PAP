 
import java.util.HashMap;
public class Carrinho
{
    private int id;
    private Utilizador user;
    private double custoTotal;
    HashMap<String, Produto> produtos;
     
    public Carrinho(int id, Utilizador user)
    {
        this.id = id;
        this.user = user;
        this.produtos = new HashMap<>();
    }
 
    public Utilizador getUser()
    {
        return this.user;
    }
    
    public double pesoTotal()
    {
        double pesoTotal = 0;
        
        for(String key : this.produtos.keySet()){
            pesoTotal = pesoTotal + this.produtos.get(key).getPeso();
        }
        
        return pesoTotal;
    }

}
