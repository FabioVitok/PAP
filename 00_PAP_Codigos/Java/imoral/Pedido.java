public class Pedido
{
    private int id;
    private Carrinho carrinho;
    
    public Pedido(Carrinho carrinho)
    {
        this.carrinho = carrinho;
    }
    
    public Carrinho getCarrinho()
    {
     return this.carrinho;   
    }
        
}
