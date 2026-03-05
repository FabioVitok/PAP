public class Pedido
{
    private int id;
    private Carrinho carrinho;
    
    public Pedido(int id, Carrinho carrinho)
    {
        this.id = id;
        this.carrinho = carrinho;
    }
    
    public Carrinho getCarrinho()
    {
        return this.carrinho;   
    }
        
}
