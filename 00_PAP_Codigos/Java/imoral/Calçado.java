public class Calçado extends Produto
{
    private static final String TIPO = "Calçado";
    public Calçado(String nome, String cor, String tamanho, int stock, double precoVenda, double precoCusto)
    {
        super(nome, TIPO, cor, tamanho, stock, precoVenda, precoCusto);
    }
}
