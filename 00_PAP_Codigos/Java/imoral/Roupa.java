public class Roupa extends Produto
{
    private static final String TIPO = "Roupa";
    public Roupa(String nome, String cor, String tamanho, int stock, double precoVenda, double precoCusto)
    {
        super(nome, TIPO, cor, tamanho, stock, precoVenda, precoCusto);
    }
}
