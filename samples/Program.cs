using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.IO;
using System.Globalization;

namespace sOf
{
    class Program
    {
        static void Main(string[] args)
        {
			if(!File.Exists("dateIn.txt"))
            {
                Console.WriteLine("dateIn.txt not found");
                return;
            }
			string[] ss = File.ReadAllLines("dateIn.txt");
			int i = 0;
			StringBuilder sb = new StringBuilder();
			foreach(string s in ss)
			{
				DateTime d = DateTime.Now;
				bool ok = false;
				int y;
				if(int.TryParse(s, out y) && 1950 < y && y < 2010)
				{
					d = DateTime.ParseExact(y.ToString() + "/01/01", "yyyy/MM/dd", CultureInfo.CurrentCulture, DateTimeStyles.None);
					ok = true;
				}
				if (!ok)
				{
					if(!DateTime.TryParseExact(s, "d/M/yyyy", CultureInfo.CurrentCulture, DateTimeStyles.None, out d))
					{
						Console.WriteLine("'invalid date format at line index {0} value {1}", i, s);
						return;
					}
				}
				sb.Append(d.ToString("yyyy-MM-dd") + "\n");
				++i;
			}
			File.WriteAllText("dateOut.txt", sb.ToString());
			Console.WriteLine("{0} dates ok", i);
        }
    }
}
