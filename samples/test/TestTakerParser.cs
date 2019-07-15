using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.IO;
using System.Globalization;

namespace sOf
{
	enum TestType {
		EN_A,
		EN_B,
		EN_C,
		IT_A,
		IT_B,
		CNTT_CB,
		CNTT_NC
	}
	class TTaker {
		static TestType sTestType;
		public static string sTestDate;
		int testType;
		string testDate;
		int weakID;
		string name;
		DateTime birthdate;
		string birthplace;
		bool name2column;
		public static void ReadTestType(string file)
		{
			string[] testType = File.ReadAllLines(file);
			sTestType = (TestType)int.Parse(testType[0]);
		}
		bool CheckIdxAndParseID(string[] attr) {
			if(attr.Length < 2)
				return false;
			int idx;
			if(!int.TryParse(attr[0], out idx))
				return false;
			if(attr[1].Length < 1)
				return false;
			char testTypeChar = attr[1].ToCharArray()[0];
			if(testTypeChar == 'A' || testTypeChar == 'B' || testTypeChar == 'C')
				testType = (int)sTestType + testTypeChar - 'A';
			else
				return false;
			if(!int.TryParse(attr[1].Substring(1, attr[1].Length - 1), out weakID))
				return false;
			testDate = TTaker.sTestDate;
			return true;
		}
		bool ParseBirthdate(string s)
		{
			s = s.Trim();
			s = s.Replace("\"", "");
			s = s.Replace("//", "");
			s = s.Replace(",", "");
			s = s.Replace("-", "/");
			bool parsed = false;
			int y;
			if(int.TryParse(s, out y) && 1930 < y && y < 2010)
			{
				birthdate = DateTime.ParseExact(y.ToString() + "/01/01", "yyyy/MM/dd", CultureInfo.CurrentCulture, DateTimeStyles.None);
				return true;
			}
			if(!parsed && DateTime.TryParseExact(s, "M/yyyy", CultureInfo.CurrentCulture, DateTimeStyles.None, out birthdate))
				parsed = true;
			if (!parsed && !DateTime.TryParseExact(s, "d/M/yyyy", CultureInfo.CurrentCulture, DateTimeStyles.None, out birthdate))
				return false;
			return true;
		}
		static bool ParseTestDate(string line) {
			DateTime dt;
			if(15 < line.Length && DateTime.TryParseExact(line.Substring(8, 8), "yyyyMMdd", CultureInfo.CurrentCulture, DateTimeStyles.None, out dt))
			{
				TTaker.sTestDate = dt.ToString("yyyy-MM-dd");
				Console.WriteLine(TTaker.sTestDate);
				return true;
			}
			
			return false;
		}
		bool ParseLine(string line)
		{
			string[] attr = line.Split('\t');
			if(!CheckIdxAndParseID(attr))
				return false;
			if(attr.Length < 5)
				return false;
			if(ParseBirthdate(attr[3]))
				name2column = false;
			else if(ParseBirthdate(attr[4]))
				name2column = true;
			else
			{
				Console.WriteLine("invalid birthdate [3] {0} [4] {1}", attr[3], attr[4]);
				return false;
			}
			if(name2column)
			{
				name = Program.RemoveDoubleSpace(attr[2] + " " + attr[3]);
				birthplace = Program.RemoveDoubleSpace(Program.MapString(attr[5]));
			}
			else
			{
				name = attr[2];
				birthplace = Program.RemoveDoubleSpace(Program.MapString(attr[4]));
			}
			testDate = TTaker.sTestDate;
			return true;
		}
		override public string ToString() {
			return testType + "\t" + testDate + "\t" + weakID + "\t" + name + "\t" + birthdate.ToString("yyyy-MM-dd") +
				"\t" + birthplace;
		}
		public static List<TTaker> ParseMultipleLines(string[] lines) {
			List<TTaker> takers = new List<TTaker>();
			foreach(string line in lines)
			{
				if(TTaker.ParseTestDate(line))
					continue;
				TTaker t = new TTaker();
				if(t.ParseLine(line))
					takers.Add(t);
			}
			return takers;
		}
	}
    class Program
    {
		public static SortedDictionary<string, string> StringMap;
		public static void ReadMap(string file) {
			StringMap = new SortedDictionary<string, string>();
			if(!File.Exists(file))
				return;
			string[] map_file = File.ReadAllLines(file);
			foreach(string s in map_file)
			{
				Char delim = '\t';
				string[] kvp = s.Split(delim);
				if(kvp.Length == 2)
					StringMap.Add(kvp[0], kvp[1]);
			}
		}
		public static string MapString(string originS)
		{
			string s = originS;
			foreach(KeyValuePair<string, string> kvp in StringMap)
			{
				int pos = s.IndexOf(kvp.Key, StringComparison.CurrentCultureIgnoreCase);
				if(-1 < pos)
				{
					if(0 < pos)
						s = s.Substring(0, pos) + kvp.Value +
							s.Substring(pos + kvp.Key.Length, s.Length - pos - kvp.Key.Length);
					else
						s = kvp.Value +
							s.Substring(pos + kvp.Key.Length, s.Length - pos - kvp.Key.Length);
				}
			}
			return s;
		}
		public static string RemoveDoubleSpace(string s) {
			while(s.IndexOf("  ") != -1)
				s = s.Replace("  ", " ");
			return s;
		}
        public static void Main(string[] args)
        {
			string fmt = "yyMMdd";
			if(args.Length == 1)
				fmt = args[0];
			TTaker.ReadTestType("testType.txt");
			Program.ReadMap("mapString.txt");
			foreach(string path in Directory.GetFiles(Directory.GetCurrentDirectory(), "*.txt"))
			{
				string file = Path.GetFileName(path);
				if(fmt.Length < file.Length) {
					string d = file.Substring(0, fmt.Length);
					DateTime dt;
					if(DateTime.TryParseExact(d, "yyMMdd", CultureInfo.CurrentCulture, DateTimeStyles.None, out dt)) {
						List<TTaker> takers = TTaker.ParseMultipleLines(File.ReadAllLines(file));
						StringBuilder sb = new StringBuilder();
						Console.WriteLine("{0} takers {1}", file + ".txt", takers.Count);
						foreach(TTaker t in takers)
							sb.Append(t.ToString() + "\n");
						File.WriteAllText(file + ".txt", sb.ToString());
					}
				}
			}
        }
    }
}
