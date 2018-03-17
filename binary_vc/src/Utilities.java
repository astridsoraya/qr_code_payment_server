/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 *
 * @author Astrid
 */
public class Utilities {
    public static int xorOperation(int a, int b) {
        if (a == b) {
            return 0;
        } else {
            return 1;
        }
    }

    public static int changeBitColorToDecimal(String byteColor) {
        int decimal = 0;
        int bit = 2;
        int j = byteColor.length() - 1;

        for (int i = 0; i < byteColor.length(); i++) {
            decimal += (Math.pow(bit, j) * Integer.parseInt(byteColor.charAt(i) + ""));
            j--;
        }

        return decimal;
    }

    public static String changeDecimalToBitColor(int decimal) {
        String res = "";
        int total = 255;

        for (int i = 0; i < 8; i++) {
            if (decimal <= total) {
                res += decimal % 2;
                decimal = decimal / 2;
            } else {
                res += 0;
            }
        }

        String byteColor = "";
        for (int i = res.length() - 1; i >= 0; i--) {
            byteColor += res.charAt(i);
        }
        return byteColor;
    }
}
