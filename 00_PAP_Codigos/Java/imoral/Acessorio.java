public class Acessorio extends Produto
{
    private static final String TIPO = "Acessorio";
    public Acessorio(String nome, String cor, String tamanho, int stock, double precoVenda, double precoCusto)
    {
        super(nome, TIPO, cor, tamanho, stock, precoVenda, precoCusto);
    }
}
