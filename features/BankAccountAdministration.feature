Feature: Checking which properties I can afford to rent from a list of given properties, based on my bank statement
  In order to rent the best property I can afford
  As a potential tenant
  I need to be able to evaluate the monthly prices from a list of available properties, against my bank statement

  Background:
    Given the properties list file is located at "/features/test_files/properties.csv"

  Scenario: Providing valid files for the list of properties and my bank statement successfully provides me with the affordability results
    Given my bank statement file is located at "/features/test_files/bank_statement.csv"
    When I perform the affordability check
    Then the result should be successful
    And the displayed message should contain the evaluated property results:
      | address                          | affordable |
      | "99  Brackley Road, KW17 9QS   " | YES        |
      | "103  Ploughley Rd, AB30 4EW   " | YES        |
      | "89  Russell Rd, FK1 1QA       " | YES        |
      | "45  Ockham Road, PO20 7YN     " | YES        |
      | "65  Guildry Street, DY7 8LT   " | NO         |
      | "55  Trinity Crescent, MK17 6YU" | YES        |
      | "103  Thames Street, S44 9PS   " | YES        |
      | "34  Broomfield Place, SO43 8HE" | NO         |
      | "78  Terrick Rd, EX39 6AX      " | YES        |
      | "33  Hounslow Rd, DN21 4PQ     " | YES        |
      | "116  Chapel Lane, PH38 6BJ    " | YES        |
      | "117  Chapel Lane, PH38 6BJ    " | NO         |

  Scenario: Maliciously attempting to load cute cat gifs posturing as CSV files should display an error
    Given my bank statement file is located at "/features/test_files/giphy_surprise.csv"
    When I perform the affordability check
    Then the result should be unsuccessful
    And the displayed message should contain the text "We only accept CSV text files files at the moment."

  Scenario: Attempting to load files with extensions other than .csv should display an error
    Given my bank statement file is located at "/features/test_files/bank_statement.txt"
    When I perform the affordability check
    Then the result should be unsuccessful
    And the displayed message should contain the text "We only accept CSV text files files at the moment."

  Scenario: Properties with missing data should be excluded from the list of results
    Given my bank statement file is located at "/features/test_files/bank_statement.csv"
    And the properties list file is located at "/features/test_files/malformed_properties.csv"
    When I perform the affordability check
    Then the result should be successful
    And the displayed message should contain the evaluated property results:
      | address                       | affordable |
      | "45  Ockham Road, PO20 7YN  " | YES        |
      | "65  Guildry Street, DY7 8LT" | NO         |
