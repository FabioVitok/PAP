public class Mala extends Produto
{
    private static final String TIPO = "Mala";
    public Mala(String nome, String cor, String tamanho, int stock, double precoVenda, double precoCusto)
    {
        super(nome, TIPO, cor, tamanho, stock, precoVenda, precoCusto);  
    }
}
