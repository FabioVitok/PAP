<<<<<<< HEAD
 
=======
>>>>>>> 4fb0673a2627fb37207e6fc0eb5e107d14143e42
import java.util.HashMap;
public class Carrinho
{
    private int id;
    private Utilizador user;
    private double custoTotal;
<<<<<<< HEAD
    HashMap<String, Produto> produtos;
=======
    HashMap<String, ProdutoCarrinho> produtos;
>>>>>>> 4fb0673a2627fb37207e6fc0eb5e107d14143e42
     
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
    
<<<<<<< HEAD
    public double pesoTotal()
    {
        double pesoTotal = 0;
        
        for(String key : this.produtos.keySet()){
            pesoTotal = pesoTotal + this.produtos.get(key).getPeso();
=======
    // Metodo para calcular o peso do carrinho ignorando se o produto está selecionado ou não
    public double pesoTotal()
    {
        double pesoTotal = 0;
        for(String key : this.produtos.keySet()){
            double pesoProduto = this.produtos.get(key).getProduto().getPeso();
            int quantidadeProduto = this.produtos.get(key).getQuantidade();
            pesoTotal = pesoTotal + (pesoProduto * quantidadeProduto);
>>>>>>> 4fb0673a2627fb37207e6fc0eb5e107d14143e42
        }
        
        return pesoTotal;
    }
<<<<<<< HEAD

=======
>>>>>>> 4fb0673a2627fb37207e6fc0eb5e107d14143e42
}
