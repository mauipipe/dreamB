Feature:
  In order to handle comments
  As a api maintainer
  I should be able to add/list comment through a REST calls

  @comment @wip
  Scenario:
    Given I send a POST request to "/beach" with values:
      | city_id | 1          |
      | name    | Boca Raton |
    And there are 0 'Comment' in the system
    And 0 saved images
    When I send a POST request to "/comment" with values:
      | beach_id   | 1                                      |
      | name       | Gandalf                                |
      | lastName   | Grey                                   |
      | desctipion | beautiful beach carved betwen 2 cliffs |
    Then the response code should be 201
    And there are 1 'Comment' in the system