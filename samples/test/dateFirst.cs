using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.IO;
using System.Globalization;

namespace Console1
{
    class Program
    {
        static void Main(string[] args)
        {
			string fmt = "dd_mm_yyyy";
			if(args.Length == 1)
				fmt = args[0];
			foreach(string s in Directory.GetFiles(Directory.GetCurrentDirectory()))
			{
				string noExt = Path.GetFileNameWithoutExtension(s);
				if(fmt.Length < noExt.Length) {
					string ext = Path.GetExtension(s);
					string d = noExt.Substring(noExt.Length - fmt.Length, fmt.Length);
					Console.Write(d + "----");
					DateTime dt;
					if(DateTime.TryParseExact(d, fmt, CultureInfo.CurrentCulture, DateTimeStyles.None, out dt)) {
						string newName = dt.ToString("yymmdd_") + noExt.Substring(0, noExt.Length - fmt.Length) + ext;
						Console.WriteLine(s + "----" + newName);
						File.Move(s, newName);
					}
				}
			}
        }
    }
}
