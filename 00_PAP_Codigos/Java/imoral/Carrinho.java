import java.util.ArrayList;
public class Carrinho
{
    private int id;
    private Utilizador user;
    private double custoTotal;
    ArrayList<ProdutoCarrinho> produtosCarrinho = new ArrayList<>();
     
    public Carrinho(int id, Utilizador user)
    {
        this.id = id;
        this.user = user;
        this.produtosCarrinho = new ArrayList<>();
    }
 
    public Utilizador getUser()
    {
        return this.user;
    }
    
    public ArrayList<ProdutoCarrinho> getProdutosCarrinho() {
        return this.produtosCarrinho;
    }
    
    // Metodo para calcular o peso do carrinho ignorando se o produto está selecionado ou não
    /*public double pesoTotal()
    {
        double pesoTotal = 0;
        for(String key : this.produtosCarrinho.keySet()){
            double pesoProduto = this.produtosCarrinho.get(key).getProduto().getPeso();
            int quantidadeProduto = this.produtosCarrinho.get(key).getQuantidade();
            pesoTotal = pesoTotal + (pesoProduto * quantidadeProduto);
        }
        
        return pesoTotal;
    }
    */
}
